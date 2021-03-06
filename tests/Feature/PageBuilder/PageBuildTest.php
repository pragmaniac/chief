<?php

namespace Thinktomorrow\Chief\Tests\Feature\PageBuilder;

use Illuminate\Support\Facades\Route;
use Thinktomorrow\Chief\FlatReferences\FlatReferenceCollection;
use Thinktomorrow\Chief\Management\Register;
use Thinktomorrow\Chief\Modules\Module;
use Thinktomorrow\Chief\Modules\TextModule;
use Thinktomorrow\Chief\Pages\PageManager;
use Thinktomorrow\Chief\Tests\Fakes\ArticlePageFake;
use Thinktomorrow\Chief\Tests\Fakes\NewsletterModuleFake;
use Thinktomorrow\Chief\Tests\TestCase;

class PageBuildTest extends TestCase
{
    use PageBuildFormParams;

    private $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDefaultAuthorization();
        config()->set('app.fallback_locale', 'nl');

        app(Register::class)->register('articles', PageManager::class, ArticlePageFake::class);

        // Create a dummy page up front based on the expected validPageParams
        $this->page = ArticlePageFake::create([
            'title:nl' => 'new title',
            'slug:nl' => 'new-slug',
            'title:en' => 'nouveau title',
            'slug:en' => 'nouveau-slug',
        ]);

        // For our project context we expect the page detail route to be known
        Route::get('pages/{slug}', function () {
        })->name('pages.show');
    }

    /** @test */
    public function it_can_fetch_all_sections_in_order()
    {
        $module    = TextModule::create(['slug' => 'eerste-text', 'content:nl' => 'eerste text']);
        $otherPage = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article text', 'slug:nl' => 'article-slug', 'published' => true]);
        $module2   = TextModule::create(['slug' => 'tweede-text', 'content:nl' => 'tweede text']);
        $module3   = NewsletterModuleFake::create(['slug' => 'newsletter', 'content:nl' => 'nieuwsbrief']);

        $this->page->adoptChild($module, ['sort' => 0]);
        $this->page->adoptChild($module2, ['sort' => 2]);
        $this->page->adoptChild($otherPage, ['sort' => 1]);
        $this->page->adoptChild($module3, ['sort' => 5]);

        $this->assertCount(4, $this->page->children());
        $this->assertCount(4, $this->page->presentChildren());

        $this->assertEquals('eerste textarticle texttweede textnieuwsbrief', $this->page->renderChildren());
    }

    /** @test */
    public function it_can_fetch_all_sections_with_multiple_pages_in_order()
    {
        $module    = TextModule::create(['slug' => 'eerste-text', 'content:nl' => 'eerste text']);
        $otherPage = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article text', 'slug:nl' => 'article-slug', 'published' => true]);
        $thirdPage = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article text', 'slug:nl' => 'article-slug-2', 'published' => true]);
        $module2   = TextModule::create(['slug' => 'tweede-text', 'content:nl' => 'tweede text']);
        $module3   = NewsletterModuleFake::create(['slug' => 'newsletter', 'content:nl' => 'nieuwsbrief']);

        $this->page->adoptChild($module, ['sort' => 0]);
        $this->page->adoptChild($module2, ['sort' => 2]);
        $this->page->adoptChild($otherPage, ['sort' => 1]);
        $this->page->adoptChild($thirdPage, ['sort' => 4]);
        $this->page->adoptChild($module3, ['sort' => 5]);

        $this->assertCount(5, $this->page->children());
        $this->assertCount(5, $this->page->presentChildren());

        // Modules show their content by default but pages do not since this is not expected behaviour
        $this->assertEquals('eerste textarticle texttweede textarticle textnieuwsbrief', $this->page->renderChildren());
    }

    /** @test */
    public function all_types_are_grouped_together_but_only_when_sorted_directly_after_each_other()
    {
        $page2 = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article-text-1', 'slug:nl' => 'article-slug', 'published' => true]);
        $page3 = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article-text-2', 'slug:nl' => 'article-slug-3', 'published' => true]);
        $module = TextModule::create(['slug' => 'tweede-text', 'content:nl' => 'module-text']);
        $page4 = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article-text-3', 'slug:nl' => 'article-slug-4', 'published' => true]);
        $this->page->adoptChild($page2, ['sort' => 1]);
        $this->page->adoptChild($page3, ['sort' => 2]);
        $this->page->adoptChild($module, ['sort' => 3]);
        $this->page->adoptChild($page4, ['sort' => 4]);
        $this->assertCount(4, $this->page->children());
        $this->assertCount(3, $this->page->presentChildren());
        $this->assertEquals(collect([
            'article-text-1article-text-2',
            'module-text',
            'article-text-3',
        ]), $this->page->presentChildren());
        $this->assertEquals('article-text-1article-text-2module-textarticle-text-3', $this->page->renderChildren());
    }


    /** @test */
    public function it_can_add_a_text_module()
    {
        config()->set('app.fallback_locale', 'nl');
        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new' => [
                    [
                        'slug' => 'text-1',
                        'trans' => [
                            'nl' => [
                                'content' => 'new content',
                            ]
                        ]
                    ]
                ]
            ]));

        $this->assertCount(1, $this->page->children());
        $this->assertInstanceOf(Module::class, $this->page->children()->first());
        $this->assertInstanceOf(TextModule::class, $this->page->children()->first());
        $this->assertEquals('new content', $this->page->children()->first()->content);
    }

    /** @test */
    public function it_can_replace_a_text_module()
    {
        // Add first text module
        $module = TextModule::create(['slug' => 'eerste-text']);
        $this->page->adoptChild($module, ['sort' => 0]);

        // Replace text module content
        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [
                    [
                        'id'    => $module->flatReference()->get(),
                        'trans' => [
                            'nl' => [
                                'content' => 'replaced content',
                            ]
                        ]
                    ]
                ]
            ]));

        $this->assertCount(1, $this->page->children());
        $this->assertEquals('replaced content', $this->page->freshChildren()->first()->content);
    }

    /** @test */
    public function it_removes_a_text_module_when_its_completely_empty()
    {
        // Add first text module
        $module = TextModule::create(['slug' => 'eerste-text']);
        $this->page->adoptChild($module, ['sort' => 0]);

        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [
                    [
                        'id'    => $module->flatReference()->get(),
                        'trans' => [
                            'nl' => [
                                'content' => '  ',
                            ]
                        ]
                    ]
                ]
            ]));

        $this->assertCount(0, $this->page->children());

        // Module is also deleted
        $this->assertNull(Module::find($module->id));
        $this->assertEquals($module->id, Module::withTrashed()->find($module->id)->id);
    }

    /** @test */
    public function it_removes_a_text_module_when_it_only_contains_empty_paragraph_tag()
    {
        // Add first text module
        $module = TextModule::create(['slug' => 'eerste-text']);
        $this->page->adoptChild($module, ['sort' => 0]);

        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [
                    [
                        'id'    => $module->flatReference()->get(),
                        'trans' => [
                            'nl' => [
                                'content' => '<p><br></p>',
                            ]
                        ]
                    ]
                ]
            ]));

        $this->assertCount(0, $this->page->children());
    }

    /** @test */
    public function it_does_not_remove_a_text_module_when_its_not_completely_empty()
    {
        // Add first text module
        $module = TextModule::create(['slug' => 'eerste-text']);
        $this->page->adoptChild($module, ['sort' => 0]);

        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [
                    [
                        'id'    => $module->flatReference()->get(),
                        'trans' => [
                            'nl' => [
                                'content' => '',
                            ],
                            'fr' => [
                                'content' => 'hi'
                            ],
                        ]
                    ]
                ],
            ]));

        $this->assertCount(1, $this->page->children());
    }

    /** @test */
    public function it_can_add_an_existing_module()
    {
        $module = NewsletterModuleFake::create(['slug' => 'nieuwsbrief', 'content:nl' => 'newsletter content']);

        // Replace text module content
        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [],
                'sections.text.remove'  => [],
                'sections.modules'      => [
                    $module->flatReference()->get()
                ],
            ]));

        $this->assertCount(1, $this->page->children());
        $this->assertInstanceOf(NewsletterModuleFake::class, $this->page->children()->first());
        $this->assertEquals('newsletter content', $this->page->children()->first()->content);
    }

    /** @test */
    public function adding_existing_module_does_not_change_anything()
    {
        $module = NewsletterModuleFake::create(['slug' => 'nieuwsbrief', 'content:nl' => 'newsletter content']);
        $this->page->adoptChild($module, ['sort' => 0]);

        // Replace text module content
        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [],
                'sections.text.remove'  => [],
                'sections.modules'      => [
                    $module->flatReference()->get()
                ],
            ]));

        $this->assertCount(1, $this->page->children());
        $this->assertInstanceOf(NewsletterModuleFake::class, $this->page->children()->first());
        $this->assertEquals('newsletter content', $this->page->children()->first()->content);
    }

    /** @test */
    public function it_can_add_pages_as_module()
    {
        $article = ArticlePageFake::create(['title:nl' => 'tweede artikel', 'slug:nl' => 'tweede-slug']);

        // Replace text module content
        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [],
                'sections.text.remove'  => [],
                'sections.modules'      => [
                    $article->flatReference()->get()
                ],
            ]));

        $this->assertCount(1, $this->page->children());
        $this->assertInstanceOf(ArticlePageFake::class, $this->page->children()->first());
        $this->assertEquals('tweede artikel', $this->page->children()->first()->title);
    }

    /** @test */
    public function it_can_remove_modules()
    {
        $module = NewsletterModuleFake::create(['slug' => 'nieuwsbrief', 'content:nl' => 'newsletter content']);
        $this->page->adoptChild($module, ['sort' => 0]);

        // Replace text module content
        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [],
                'sections.text.replace' => [],
                'sections.text.remove'  => [],
                'sections.modules'      => [
                    // Removing module by not including them in the listing
                ],
            ]));

        $this->assertCount(0, $this->page->children());
    }

    /** @test */
    public function it_can_set_the_order()
    {
        $text_module = TextModule::create(['slug' => 'eerste-text', 'content:nl' => 'eerste text']);
        $otherPage = ArticlePageFake::create(['title:nl' => 'artikel title', 'content:nl' => 'article text', 'slug:nl' => 'article-slug']);
        $newsletter = NewsletterModuleFake::create(['slug' => 'tweede-text', 'content:nl' => 'tweede text']);

        $this->page->adoptChild($text_module, ['sort' => 0]);

        $this->asAdmin()
            ->put(route('chief.back.managers.update', ['articles', $this->page->id]), $this->validPageParams([
                'sections.text.new'     => [
                    [
                        'slug' => 'text-1',
                        'trans' => [
                            'nl' => [
                                'content' => 'new text',
                            ]
                        ]
                    ],
                ],
                'sections.text.replace' => [
                    [
                        'id' => $text_module->flatReference()->get(),
                        'trans' => [
                            'nl' => [
                                'content' => 'replaced module',
                            ]
                        ]
                    ],
                ],
                'sections.text.remove'  => [],
                'sections.modules'      => [
                    $otherPage->flatReference()->get(),
                    $newsletter->flatReference()->get(),
                ],
                'sections.order' => [
                    $otherPage->flatReference()->get(),
                    $newsletter->flatReference()->get(),
                    'text-1',
                    $text_module->flatReference()->get(),
                ]
            ]));

        $this->assertCount(4, $this->page->children());

        $this->assertEquals([
            $otherPage->flatReference()->get(),
            $newsletter->flatReference()->get(),
            TextModule::findBySlug('text-1')->flatReference()->get(),
            $text_module->flatReference()->get()],
            (new FlatReferenceCollection($this->page->children()->all()))->toFlatReferences()->all());
    }
}
