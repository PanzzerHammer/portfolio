<?php
$statLivre = $pdo->getLivreStat();
$statFilm = $pdo->getFilmStat();
$statMusique = $pdo->getMusiqueStat();
$nbLivre = 0;
$nbFilm = 0;
$nbMusique = 0;
if (isset($statLivre)) {
    $nbLivre = $statLivre['nbLivre'];
}
if (isset($statFilm)) {
    $nbFilm = $statFilm['nbFilm'];
}
if (isset($statMusique)) {
    $nbMusique = $statMusique['nbMusique'];
}

$statPhysique = $pdo->getPhysiqueStat();
$statNumerique = $pdo->getNumeriqueStat();
$nbPhysique = 0;
$nbNumerique = 0;
if (isset($statPhysique)) {
    $nbPhysique = $statPhysique['nbPhysique'];
}
if (isset($statNumerique)) {
    $nbNumerique = $statNumerique['nbNumerique'];
}
?>
<div class="box feature container">
    <div class="row">
        <div class="6u 12u(medium)">
            <canvas id="myChart" width="200" height="200"></canvas>
            <script>
                let ctx = document.getElementById("myChart").getContext('2d');
                let myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Livres", "Musique", "Film"],
                        datasets: [{
                                label: "Nombre d'articles vendu",
                                data: [<?= $nbLivre ?>, <?= $nbFilm ?>, <?= $nbMusique ?>],
                                backgroundColor: [
                                    'rgba(0,191,255, 0.2)',
                                    'rgba(255,0,255, 0.2)',
                                    'rgba(0,128,0, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(0,191,255, 1)',
                                    'rgba(255,0,255, 1)',
                                    'rgba(0,128,0, 1)'
                                ],
                                borderWidth: 1
                            }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "Nombre d'articles vendu le mois dernier par type",
                            fontSize: 25
                        },
                        pieceLabel: {
                            render: 'percentage',
                            fontColor: ['rgba(0,191,255, 1)', 'rgba(255,0,255, 1)', 'rgba(0,128,0, 1)']
                        }
                    }
                });
            </script>
        </div>
        <div class="6u 12u(medium)">
            <canvas id="myChart2" width="200" height="200"></canvas>
            <script>
                let ctx2 = document.getElementById("myChart2").getContext('2d');
                let myChart2 = new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: ["Physique", "Numérique"],
                        datasets: [{
                                label: "Nombre d'articles vendu",
                                data: [<?= $nbPhysique ?>, <?= $nbNumerique ?>],
                                backgroundColor: [
                                    'rgba(255,140,0, 0.2)',
                                    'rgba(128,128,128, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255,140,0, 1)',
                                    'rgba(128,128,128, 1)'
                                ],
                                borderWidth: 1
                            }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "Nombre d'articles vendu le mois dernier par support",
                            fontSize: 25
                        },
                        pieceLabel: {
                            render: 'percentage',
                            fontColor: ['rgba(255,140,0, 1)', 'rgba(128,128,128, 1)']
                        }
                    }
                });
            </script>
        </div>
    </div>
</div>