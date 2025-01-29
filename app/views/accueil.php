<header>
        <section>
            <nav class="navbar navbar-expand-lg fixed-top top-banner">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img style="width: 300px;" src="icons/Logo.png" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        </ul>
                        <div class="d-flex nav-menu">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#nombre-enfants">Generer des cadeaux</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#cadeaux">Voir les cadeaux</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#contact">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </section>
            <?= $banner?>
    </header>

    <main>
        <?= $depot ?>
        <?= $enfant ?>
        <form id="confirmation-form" method="POST" action="confirmation">
            <div id="cadeaux-list">
                <?= $cadeaux ?>
            </div>
            <div class="form-group d-flex" style="transform:translate(-20%);margin-left:50%;">
                <button type="submit" class="btn btn-success me-2" name="confirmer">Confirmer</button>
                <button type="button" class="btn btn-secondary" id="regenerer" onclick="regenererCadeaux()">Régénérer</button>
            </div>
        </form>
    </main>