<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-neutral-900">حذف حساب کاربری</h2>
        <p class="mt-1 text-sm text-neutral-500">پس از حذف حساب، تمامی منابع و داده‌های آن به طور دائمی حذف خواهند شد. قبل از حذف حساب، هرگونه داده یا اطلاعاتی که می‌خواهید نگه دارید را دانلود کنید.</p>
    </header>

    <button
        type="button"
        class="btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        حذف حساب کاربری
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-neutral-900">آیا از حذف حساب کاربری خود اطمینان دارید؟</h2>

            <p class="mt-1 text-sm text-neutral-500 leading-relaxed">
                پس از حذف حساب، تمامی منابع و داده‌های آن به طور دائمی حذف خواهند شد. لطفاً رمز عبور خود را وارد کنید تا تایید کنید که می‌خواهید حساب خود را به طور دائمی حذف کنید.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="رمز عبور" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="رمز عبور" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="btn-secondary" x-on:click="$dispatch('close')">انصراف</button>
                <button type="submit" class="btn-danger">حذف حساب کاربری</button>
            </div>
        </form>
    </x-modal>
</section>
