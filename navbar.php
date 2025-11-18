<header class="shadow font-default" role="banner">
    <nav
        class="flex items-center justify-between p-3 lg:px-8"
        aria-label="Main navigation">
        <div class="flex">
            <a href="/<?= $lang ?>/index" class="-m-1.5 p-1.5" aria-label="Sacith Home">
                <img
                    class="h-8 w-auto"
                    src="/public/logo/Logotipo_Sacith_piccolo.png"
                    alt="Logo SACITH" />
            </a>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="/<?= $lang ?>/product" class="text-sm/6 text-gray-900"><?= $lang == "it" ? "Prodotti" : "Product" ?></a>
            <a href="/<?= $lang ?>/contact" class="text-sm/6 text-gray-900"><?= $lang == "it" ? "Contatti" : "Contact" ?></a>
            <a href="/<?= $lang ?>/about" class="text-sm/6 text-gray-900"><?= $lang == "it" ? "Chi Siamo" : "About Us" ?></a>
            <a href="/<?= $lang ?>/new" class="text-sm/6 text-gray-900"><?= $lang == "it" ? "Novità" : "New" ?></a>
        </div>
        <div class="hidden lg:flex rounded-full" aria-label="Selettore lingua">
            <button type="button" class="<?php echo ($lang == 'it') ? 'bg-primary text-white' : 'bg-white text-primary'; ?> py-1 px-3 font-semibold rounded-md cursor-pointer" id="it" onclick="setLang('it')" aria-pressed="<?= $lang == 'it' ? 'true' : 'false' ?>">IT</button>
            <button type="button" class="<?php echo ($lang == 'en') ? 'bg-primary text-white' : 'bg-white text-primary'; ?> py-1 px-3 font-semibold rounded-md cursor-pointer" onclick="setLang('en')" id="en" aria-pressed="<?= $lang == 'en' ? 'true' : 'false' ?>">EN</button>
        </div>
        <div class="flex lg:hidden">
            <button
                type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                id="menu-button"
                aria-label="Apri menu principale"
                aria-controls="mobile-menu"
                aria-expanded="false">
                <svg
                    class="size-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </nav>
    <!-- Overlay (cliccabile per chiudere il menu) -->
    <div
        id="menu-overlay"
        class="hidden fixed inset-0 z-40 bg-black bg-opacity-50"></div>
    <!-- Mobile menu -->
    <nav
        class="fixed inset-y-0 right-0 z-50 w-3/4 bg-white opacity-0 translate-x-full transform transition-all duration-300 ease-in-out"
        id="mobile-menu"
        aria-label="Menu mobile"
        tabindex="-1">
        <div class="flex items-center justify-between p-6">
            <a href="/<?= $lang ?>/index" class="-m-1.5 p-1.5" aria-label="Sacith Home">
                <img
                    class="h-8 w-auto"
                    src="/public/logo/Logotipo_Sacith_piccolo.png"
                    alt="Logo SACITH" />
            </a>
            <button
                type="button"
                class="-m-2.5 rounded-md p-2.5 text-gray-700"
                id="close-button"
                aria-label="Chiudi menu">
                <svg
                    class="size-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-6 flow-root">
            <ul class="space-y-6 px-16">
                <li>
                    <a
                        href="/<?= $lang ?>/product"
                        class="block text-[20px] sm:text-[44px] rounded-lg px-3 py-2 text-base text-gray-900 hover:bg-gray-50"><?= $lang == "it" ? "Prodotti" : "Product" ?></a>
                </li>
                <li>
                    <a href="/<?= $lang ?>/contact" class="block text-[20px] sm:text-[44px] rounded-lg px-3 py-2 text-base text-gray-900 hover:bg-gray-50"><?= $lang == "it" ? "Contatti" : "Contact" ?></a>
                </li>
                <li>
                    <a
                        href="/<?= $lang ?>/about"
                        class="block text-[20px] sm:text-[44px] rounded-lg px-3 py-2 text-base text-gray-900 hover:bg-gray-50"><?= $lang == "it" ? "Chi Siamo" : "About Us" ?></a>
                </li>
                <li>
                    <a
                        href="/<?= $lang ?>/new"
                        class="block text-[20px] sm:text-[44px] rounded-lg px-3 py-2 text-base text-gray-900 hover:bg-gray-50"><?= $lang == "it" ? "Novità" : "New" ?></a>
                </li>
                <li>
                    <div class="flex rounded-full w-fit" aria-label="Selettore lingua">
                        <button type="button" class="<?php echo ($lang == 'it') ? 'bg-primary text-white' : 'bg-white text-primary'; ?> py-1 px-3 font-semibold rounded-md cursor-pointer" id="it-mobile" onclick="setLang('it')" aria-pressed="<?= $lang == 'it' ? 'true' : 'false' ?>">IT</button>
                        <button type="button" class="<?php echo ($lang == 'en') ? 'bg-primary text-white' : 'bg-white text-primary'; ?> py-1 px-3 font-semibold rounded-md cursor-pointer" onclick="setLang('en')" id="en-mobile" aria-pressed="<?= $lang == 'en' ? 'true' : 'false' ?>">EN</button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- <script>
        function setLang(language) {
            const url = new URL(window.location.href);

            // Split del pathname: es. ['', 'it', 'contact']
            const segments = url.pathname.split('/');

            // Controlla se c'è almeno una lingua nel primo segmento
            if (segments.length >= 2 && segments[1].length === 2) {
                segments[1] = language;

                url.pathname = segments.join('/');

                // (opzionale) aggiorna anche i parametri ?lang=...
                url.searchParams.set('lang', language);

                // Reindirizza alla nuova URL
                window.location.href = url.toString();
            } else {
                console.error("Struttura URL non valida per il cambio lingua");
            }
        }
    </script> -->
    <script>
        function setLang(language) {
            // 1. Imposta il cookie
            document.cookie = "lang=" + language + "; path=/; max-age=" + 60 * 60 * 24 * 30;

            // 2. Aggiorna l'URL con il parametro ?lang=it o ?lang=en (senza ricaricare)
            const url = new URL(window.location.href);
            url.searchParams.set('lang', language);
            window.history.replaceState({}, '', url);

            // 3. Ricarica la pagina
            location.reload();
        }
    </script>
</header>