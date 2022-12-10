<?php
/*
Template Name: Vacancies Poland Project-manager Page
*/
get_header();
?>
    <header class="header">
        <div class="container">
            <nav class="header__nav">
                <div class="container">
                    <a class="header__link" aria-label="link do strony głównej GoITeens" href="<?php echo home_url('/'); ?>"
                       target="_blank" rel="noopener noreferrer nofollow">
                        <img class="header__logo"
                             src="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/logo.svg"
                             width="143" height="37" alt="Logo firmy GoITeens" />
                    </a>

                    <button class="btn btn-tablet" type="button" data-modal="backdrop">
                        WYŚLIJ CV
                    </button>
                </div>
            </nav>
            <div class="header__text-block">
                <h1 class="header__title text-accent">
                    &#91; <span class="text-white">OFERTA PRACY ZDALNEJ <br> Project Manager_</span> &#93;
                </h1>

            </div>
            <button class="btn btn--mobile" type="button" data-modal="backdrop">
                WYŚLIJ CV
            </button>
        </div>
    </header>
    <div class="header__decoration"></div>
    <main>
        <section class="company section">
            <div class="container">
                <div class="company__wrapper">
                    <h2 class="company__title text-yellow">&#91; Project Manager produktu edukacyjnego dla
                        dzieci&#95;&nbsp;&#93;
                    </h2>

                    <div class="company__wrapper-info">
                        <h3 class="company__wrapper-info-title">Cześć! 🚀</h3>


                        <p class="company__text">
                            Jesteśmy GoIT - międzynarodową firmą z sektora EdTech, która zajmuje się edukacją w branży IT
                            dla
                            osób dorosłych i
                            dzieci. Pomagamy naszym klientom wejść do IT i poczuć się pewnie na rynku pracy.
                        </p>
                        <p class="company__text">
                            Potwierdzeniem tego jest 4500 osób rocznie, które korzystają z naszych szkoleń. Od niedawna
                            postanowiliśmy rozszerzyć
                            nasze działania na nową grupę docelową – młodzież i ich rodziców.

                        </p>
                        <p class="company__text">
                            Dzięki umiejętnościom zdobytym w GoITeens, dziecko (8-16 lat) będzie w stanie nie tylko pracować
                            w
                            IT w przyszłości, ale
                            też rozwinąć swoje IQ, umiejętność logicznego myślenia i zdobędzie nowych kolegów i koleżanki o
                            podobnych
                            zainteresowaniach.
                            Jeżeli brzmi to interesująco, możesz zapoznać się z informacjami o produkcie tutaj → <a
                                    class="link text-accent" href="<?php echo site_url() ?>/pl/course/" target="_blank"
                                    rel="noopener noreferrer nofollow"><?php echo site_url() ?>/pl/course/</a>

                        </p>
                    </div>
                    <picture class="company__picture">
                        <source srcset="
                                <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/company/students.webp    1x,
                                <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/company/students@2x.webp 2x
                              " type="image/webp" />

                        <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/company/students@2x.jpg 2x"
                                type="image/jpeg" />

                        <img class="company__img"
                             src="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/company/students.jpg"
                             width="570" height="400" alt="Grupa studencka" loading="lazy" />
                    </picture>
                </div>
            </div>
        </section>
        <section class="offer section">

            <div class="container ">
                <h2 class="offer__title text-yellow">
                    &#91; Kogo szukamy?&nbsp;&#95;&nbsp;&#93;
                </h2>
                <div class="offer__wrapper">
                    <!-- <div class="offer__description"> -->
                    <div class="offer__text-wrap">
                        <p class="offer__text"><span class="text-bold">Project Manager’a</span>(mini-CEO 😎 ), który
                            zostanie
                            częścią naszego
                            zespołu
                            tworzonego przez ludzi z
                            pasją oraz miłością do
                            nowych technologii i rozwiązań.</p>
                        <p class="offer__text text-bold">Nasz idealny kandydat będzie odpowiedzialny za :
                        </p>
                    </div>
                    <ul class="offer__list">
                        <li class="offer__list-item">
                            Budowanie pozycji i wizerunku nowego produktu na rynku

                        </li>
                        <li class="offer__list-item">
                            Współokreślanie strategii sprzedaży/lejków sprzedażowych
                            i promocji usługi zgodnie z celami organizacji

                        </li>
                        <li class="offer__list-item">
                            Podejmowanie działań skierowanych na uzyskanie założonego wyniku z uwzględnieniem jakości,
                            realizacji i rentowności


                        </li>
                        <li class="offer__list-item">
                            Podejmowanie działań skierowanych na uzyskanie założonego wyniku z uwzględnieniem jakości,
                            realizacji i rentowności


                        </li>
                        <li class="offer__list-item">
                            Zarządzanie zespołem – wyznaczanie zadań, wspieranie, motywowanie, rozwijanie, kontrola pracy

                        </li>
                        <li class="offer__list-item">
                            Zarządzanie i kontrolowanie pracy zewnętrznych
                            dostawców usług



                        </li>
                        <li class="offer__list-item">
                            Analizę marketingową i sprzedażową oraz
                            raportowanie wyników



                        </li>
                    </ul>
                    <!-- </div> -->
                    <picture class="offer__picture">
                        <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/offer/offer.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/offer/offer@2x.webp 2x"
                                type="image/jpeg" media="(min-width: 1280px)" />
                        <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/offer/offer.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/offer/offer@2x.jpg 2x"
                                type="image/jpeg" media="(min-width: 1280px)" />


                        <img class="offer__img"
                             src="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/offer/offer.jpg"
                             width="467" height="648" alt="Grupa studencka" loading="lazy" />
                    </picture>
                </div>

            </div>

        </section>
        <section class="requirements section">
            <div class="container requirements__container">
                <h2 class="requirements__title text-yellow">&#91; Czego oczekujemy?&#95; &#93;</h2>
                <ul class="requirements__list">
                    <li class="requirements__list-item">
                        Doświadczenia w zarządzaniu min. 5 osobowym zespołem
                    </li>
                    <li class="requirements__list-item">Znajomości rynku szkoleń i branży edukacyjnej (mile widziane w
                        obszarze
                        IT)
                    </li>
                    <li class="requirements__list-item">Doświadczenia w kształtowaniu procesu wspierania sprzedaży i lejków
                        marketingowych</li>
                    <li class="requirements__list-item">Doskonałych umiejętności organizacyjnych i zdolności zarządzania
                        czasem
                    </li>
                    <li class="requirements__list-item">
                        Znajomości języka rosyjskiego
                        lub angielskiego w stopniu umożliwiającym swobodną komunikację w mowie i piśmie
                    </li>

                </ul>

            </div>

        </section>
        <section class="section responsibility">
            <div class="container">
                <div class="responsibility__wrapper">
                    <h2 class="responsibility__title text-white ">&#91; Oferujemy&#95; &#93;</h2>

                    <ul class="responsibility__list">
                        <li class="responsibility__item">Elastyczny grafik pracy - dla nas liczy się rezultat
                        </li>
                        <li class="responsibility__item">Możliwość pracy zdalnej ze sporadycznymi spotkaniami w warszawskim
                            biurze
                        </li>
                        <li class="responsibility__item">
                            Pracę w międzynarodowym, zgranym zespole
                        </li>
                        <li class="responsibility__item">Realny wpływ na biznes oraz kształtowanie strategii firmy</li>
                        <li class="responsibility__item">Formę zatrudnienia do wygodnego wyboru:
                            Umowa o pracę lub B2B</li>
                        <li class="responsibility__item">Elementy systemu wynagradzania będą uzależnione
                            od doświadczenia i dostosowane do potrzeb</li>
                        <li class="responsibility__item">Brak rutyny i stereotypów</li>
                    </ul>

                    <picture class="responsibility__picture">

                        <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people@2x.jpg 2x"
                                type="image/jpeg" media="(min-width: 1280px)" />

                        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people@2x.webp 2x
          " type="image/webp" media="(min-width: 1280px)" />

                        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people_md.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people_md@2x.webp 2x
          " type="image/webp" media="(min-width: 768px)" />

                        <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people_md.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people_md@2x.jpg 2x"
                                type="image/jpeg" media="(min-width: 768px)" />
                        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people@2x.webp 2x
          " type="image/webp" media="(max-width: 767px)" />

                        <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people@2x.jpg 2x"
                                type="image/jpeg" media="(max-width: 767px)" />

                        <img class="responsibility__img"
                             src="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/responsibility/people.jpg"
                             width="472" height="408" alt="Spotkanie robocze w GoIT" loading="lazy" />
                    </picture>
                </div>
            </div>
        </section>
        <section class="conditions section">
            <div class="container">



                <h3 class="conditions__title">
                    &#91; SPODOBAŁA CI SIĘ OFERTA?&#95; &#93;
                </h3>
                <p class="conditions__subtitle">
                    Wyślij CV już teraz i bądźmy w kontakcie!

                </p>
                <button class="btn" type="button" data-modal="backdrop">
                    WYŚLIJ CV
                </button>


                <p> Jeżeli masz jakiekolwiek PYTANIA dotyczące oferty - napisz do nas na <a class="conditions__link"
                                                                                            href="mailto:hr@goit.global">hr@goit.global</a>
                </p>



            </div>
        </section>
        <section class="recommendations section">
            <div class="container">
                <h2 class="recommendations__title">
                    &#91; ZAREKOMENDUJ OFERTĘ ZNAJOMEMU&#95;&nbsp;&#93;
                </h2>

                <button class="btn recommendations__btn" type="submit" data-modal="backdrop">
                    WYŚLIJ CV
                </button>
            </div>
        </section>
        <section class="contacts">
            <div class="container">
                <nav class="contacts__nav">
                    <a class="contacts__nav-link" href="<?php echo home_url('/'); ?>" target="_blank"
                       rel="noopener noreferrer nofollow" aria-label="link do strony głównej GoITeens">
                        <img class="contacts__nav-logo"
                             src="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/logo.svg"
                             width="143" height="37" alt="Logo firmy GoITeens" />
                    </a>
                </nav>
                <div class="contacts__mail">
                    <h3 class="contacts__mail-title">GoIT</h3>
                    <a class="contacts__mail-link" href="mailto:hr@goit.global">hr@goit.global</a>
                </div>
                <div class="contacts-social">
                    <ul class="contacts-social__list">
                        <li class="contacts-social__list-item">
                            <a class="contacts-social__list-link" target="_blank" rel="noopener noreferrer nofollow"
                               href="https://www.facebook.com/goit.polska"> [ Facebook ] </a>
                        </li>
                        <li class="contacts-social__list-item">
                            <a class="contacts-social__list-link" target="_blank" rel="noopener noreferrer nofollow"
                               href="https://instagram.com/goitpolska?igshid=YmMyMTA2M2Y="> [ Instagram ] </a>
                        </li>
                        <li class="contacts-social__list-item">
                            <a class="contacts-social__list-link" target="_blank" rel="noopener noreferrer nofollow"
                               href="https://www.linkedin.com/company/goit-polska"> [ Linkedin ] </a>
                        </li>

                    </ul>
                </div>
            </div>
        </section>

    </main>
    <footer class="footer">
        <div class="container">
            <ul class="footer__list">
                <li class="footer__item">
                    <button class="footer__link" type="button" data-modal="privacy-modal">Klauzula informacyjna</button>
                </li>

            </ul>
        </div>
    </footer>
    <div class="backdrop is-hidden" id="backdrop">
        <div class="modal">
            <button class="modal-button" data-modal-close>
                <svg class="modal-icon" width="11" height="11">
                    <use
                            href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#modalclose">
                    </use>
                </svg>
            </button>
            <p class="modal-title">Zostaw swoje dane i będziemy w kontakcie</p>
            <form enctype="multipart/form-data" method="POST" class="modal-form" id="modal-form">
                <div class="form-field">
                    <input class="form-input" type="text" name="name" id="name" maxlength="100" placeholder=" " required />
                    <label class="form-label" for="name">Imię *</label>
                    <svg class="modal-svg" width="18" height="18">
                        <use
                                href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#modalperson">
                        </use>
                    </svg>
                </div>
                <div class="form-field">
                    <input class="form-input" type="tel" name="tel" id="tel" required />
                </div>
                <div class="form-field">
                    <input class="form-input" type="email" name="email" id="email" placeholder=" " required />
                    <label class="form-label" for="email">Email *</label>
                    <svg class="modal-svg" width="18" height="18">
                        <use
                                href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#modalemail">
                        </use>
                    </svg>
                </div>
                <div class="form-field">
                    <input class="form-input" type="text" name="social" id="social" placeholder=" " required />
                    <label class="form-label" for="social">Link do Facebook, LinkedIn lub CV *</label>
                    <svg class="modal-svg" width="18" height="18">
                        <use
                                href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#link">
                        </use>
                    </svg>
                </div>
                <div class="form-field form-field-message">
                <textarea class="form-input form-message" name="message" id="message" rows="10"
                          placeholder=" "></textarea>

                    <label class="form-label" for="message">List motywacyjny</label>
                    <svg class="modal-svg" width="18" height="18">
                        <use
                                href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#modalemail">
                        </use>
                    </svg>
                </div>
                <div class="form-field">
                    <input class="file-input" type="file" name="file" id="file" accept=".doc, .docx, .pdf, .rtf" />
                    <svg class="modal-svg" width="18" height="18" data-file-svg>
                        <use
                                href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#file">
                        </use>
                    </svg>
                    <p class="alert hide"></p>
                </div>
                <button type="submit" class="btn" aria-label="submit">WYŚLIJ CV</button>
                <div class="form-term ">
                    <label>
                        <input class="form-term-checkbox custom-checkbox" type="checkbox" name="user-policy" value="accept"
                               checked required />
                        <span class="custom-checkbox"></span>
                        Wyrażam zgodę na przetwarzanie moich danych osobowych przez GoIT Polska 00-004 Warszawa ul. ALEJE
                        JEROZOLIMSKIE 85/21, NIP: 7011007541 zawartych w załączonych dokumentach aplikacyjnych (w tym
                        wizerunku),
                        na
                        potrzeby bieżącej rekrutacji. Zgoda jest dobrowolna i może być w każdym czasie wycofana.<br>
                        Dodatkowo wyrażam zgodę na przetwarzanie moich danych osobowych zawartych w załączonych dokumentach
                        aplikacyjnych (w tym wizerunku), na potrzeby przyszłych rekrutacji przez okres 12 miesięcy. Zgoda
                        jest
                        dobrowolna i może być w każdym czasie wycofana.
                    </label>
                </div>
            </form>
        </div>
    </div>
    <div class="notify hide">
        <p class="notify__text">Dziękujemy za zgłoszenie się na naszą ofertę!</p>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/cool.svg" alt="thx" width="100"
             height="100" />
    </div>
    <div class="backdrop is-hidden" id="privacy-modal">
        <div class="modal modal__info">
            <button class="modal-button" aria-label="modal close" data-modal-close>
                <svg class="modal-icon" width="11" height="11">
                    <use
                            href="<?php echo get_template_directory_uri(); ?>/assets/images/pl-vacancies-pm/modal-sprite.svg#modalclose">
                    </use>
                </svg>
            </button>
            <p class="modal-title">Klauzula informacyjna:</p>
            <p>Administratorem danych osobowych jest GoIT Polska 00-004 Warszawa ul. ALEJE JEROZOLIMSKIE 85/21, NIP:
                7011007541.
            </p>
            <p>Moje dane osobowe przetwarzane są w celu rekrutacji przez Administratora.</p>
            <p>Wiem, że przysługują mi następujące prawa:</p>
            <ul>
                <li>prawo żądania dostępu do swoich danych,</li>
                <li>prawo do ich sprostowania,</li>
                <li>prawo do usunięcia danych,</li>
                <li>prawo do ograniczenia przetwarzania,</li>
                <li>prawo do wniesienia sprzeciwu oraz prawo do przenoszenia danych.</li>
            </ul>
            <p>Więcej informacji na temat przetwarzania danych osobowych, znajduje się w Polityce Prywatności
                Administratora.
            </p>
        </div>
    </div>
<?php
get_footer();
