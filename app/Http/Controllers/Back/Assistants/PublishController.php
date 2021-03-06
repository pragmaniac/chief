<?php

namespace Thinktomorrow\Chief\App\Http\Controllers\Back\Assistants;

use Illuminate\Http\Request;
use Thinktomorrow\Chief\Management\Managers;
use Thinktomorrow\Chief\App\Http\Controllers\Controller;

class PublishController extends Controller
{
    /** @var Managers */
    private $managers;

    public function __construct(Managers $managers)
    {
        $this->managers = $managers;
    }

    public function publish(Request $request, $key, $id)
    {
        $manager = $this->managers->findByKey($key, $id);

        $manager->assistant('publish')
                ->guard('publish')
                ->publish();

        return redirect()->back()->with('messages.success', $manager->details()->title .' is gepubliceerd. <a href="' . $manager->previewUrl() . '" target="_blank">Bekijk de pagina online</a>.');
    }

    public function draft(Request $request, $key, $id)
    {
        $manager = $this->managers->findByKey($key, $id);

        $manager->assistant('publish')
                ->guard('draft')
                ->draft();

        return redirect()->back();
    }
}
