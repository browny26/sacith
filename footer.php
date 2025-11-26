<footer class="bg-white text-gray-800 p-[28px] lg:px-8 mt-[120px] border-t border-gray-200 font-default">
    <div class="container mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <address class="text-center sm:text-left mb-10 sm:mb-0">
                <img
                    class="h-[58px] w-auto"
                    src="/public/logo/Logotipo_Sacith_piccolo.png"
                    alt="Logo SACITH" />
                <p class="text-sm mt-2 sm:ps-[14px]">Via Luigi Pirandello, 21<br>21012, Cassano Magnago (VA)<br>P.iva: IT04400010965</p>
                <div class="mt-4 sm:ps-[14px] flex flex-col items-center sm:items-start">
                    <a href="tel:+390331619011" class="flex items-center space-x-2">
                        <img
                            src="/public/icons/phone-icon.png"
                            alt="Telefono" />
                        <!-- <i class="fa-solid fa-phone-volume text-primary"></i> -->
                        <span>+39 0331 619011</span>
                    </a>
                    <a href="mailto:info@sacith.com" class="flex items-center space-x-2 mt-2">
                        <img
                            src="/public/icons/email-icon.png"
                            alt="Email" />
                        <!-- <i class="fa-regular fa-envelope text-primary"></i> -->
                        <span>info@sacith.com</span>
                    </a>
                </div>
            </address>
            <nav class="flex space-x-12" aria-label="Footer">
                <div>
                    <h2 class="py-[5px] font-medium text-primary text-[14px]"><?= $lang == "it" ? "PRODOTTI" : "PRODUCTS" ?></h2>
                    <ul class="text-[12px] space-y-4 mt-2">
                        <li><a href="/product" class="hover:font-semibold"><?= $lang == "it" ? "Idromassaggio" : "Whirlpool" ?></a></li>
                        <li><a href="/product" class="hover:font-semibold"><?= $lang == "it" ? "Docce" : "Shower" ?></a></li>
                        <li><a href="/product" class="hover:font-semibold"><?= $lang == "it" ? "Arredamento" : "Forniture" ?></a></li>
                    </ul>
                </div>
                <div>
                    <h2 class="py-[5px] font-medium text-primary text-[14px]"><?= $lang == "it" ? "PAGINE" : "PAGES" ?></h2>
                    <ul class="text-[12px] space-y-4 mt-2">
                        <li><a href="/<?= $lang ?>/about" class="hover:font-semibold"><?= $lang == "it" ? "Chi siamo" : "Who we are" ?></a></li>
                        <li><a href="/<?= $lang ?>/catalogue" class="hover:font-semibold"><?= $lang == "it" ? "Cataloghi" : "Catalogues" ?></a></li>
                        <li><a href="/<?= $lang ?>/new" class="hover:font-semibold"><?= $lang == "it" ? "Novità" : "New" ?></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</footer>