<modal id="delete-article" class="large-modal">
    <div v-cloak>
        <div class="column-12">
            <h2 class="formgroup-label">Super. <br>Ben je zeker. 👍</h2>
        </div>
    </div>
    <div slot="footer">
        <button class="btn btn-o-tertiary">Verwijder de artikels</button>
        <a class="btn btn-link text-secondary" @click="closeModal('delete-article')">annuleer</a>
    </div>
</modal>

