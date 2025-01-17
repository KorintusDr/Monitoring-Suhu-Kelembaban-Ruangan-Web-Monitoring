<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemantauan Sensor Realtime</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .card-body {
            font-size: 24px;
        }
        canvas {
            max-height: 300px;
        }
        .diagram-container {
            display: flex;
            justify-content: center;
        }
    </style>
    <script>
        let dataSuhu = [];
        let dataKelembaban = [];
        let labelWaktu = [];

        $(document).ready(function(){
            setInterval(function() {
                // Ambil data suhu
                $.get("<?php echo base_url('Monitoring/ceksuhu'); ?>", function(data) {
                    const suhu = parseFloat(data);
                    if (dataSuhu.length >= 10) dataSuhu.shift();
                    dataSuhu.push(suhu);
                    $("#nilai-suhu").text(suhu); // Update kotak suhu
                });

                // Ambil data kelembaban
                $.get("<?php echo base_url('Monitoring/cekkelembaban'); ?>", function(data) {
                    const kelembaban = parseFloat(data);
                    if (dataKelembaban.length >= 10) dataKelembaban.shift();
                    dataKelembaban.push(kelembaban);
                    $("#nilai-kelembaban").text(kelembaban); // Update kotak kelembaban
                });

                const waktuSekarang = new Date().toLocaleTimeString();
                if (labelWaktu.length >= 10) labelWaktu.shift();
                labelWaktu.push(waktuSekarang);

                perbaruiDiagram();
            }, 1000);
        });

        function perbaruiDiagram() {
            diagramGaris.update();
        }
    </script>
</head>
<body>

<div class="container text-center mt-5">
<h2>Pemantauan Kondisi Ruang Penyimpanan Obat <br> di Apotek A Secara Realtime Teknologi IoT</h2>
<p>Pemanfaatan teknologi Internet of Things (IoT) di Apotek A dirancang untuk mengatasi tantangan dalam 
    menjaga stabilitas suhu dan kelembaban ruang penyimpanan obat. Kondisi lingkungan yang terpantau secara 
    real-time memungkinkan pengelolaan yang lebih efektif terhadap faktor-faktor yang memengaruhi kualitas obat,
     sehingga mendukung standar penyimpanan yang lebih optimal dan efisien. Inovasi ini bertujuan untuk memastikan
      keamanan dan efektivitas obat serta meningkatkan kepercayaan konsumen terhadap layanan apotek.</p>


    <div class="row justify-content-center mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Suhu</h3>
                </div>
                <div class="card-body">
                    <h1><span id="nilai-suhu">0</span>°C</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Kelembaban</h3>
                </div>
                <div class="card-body">
                    <h1><span id="nilai-kelembaban">0</span>%</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3>Visualisasi Data Realtime</h3>
        <div class="diagram-container">
            <canvas id="diagramGaris"></canvas>
        </div>
    </div>
</div>

<script>
    const contextDiagram = document.getElementById('diagramGaris').getContext('2d');

    const diagramGaris = new Chart(contextDiagram, {
        type: 'line',
        data: {
            labels: labelWaktu,
            datasets: [
                {
                    label: 'Suhu (°C)',
                    data: dataSuhu,
                    borderColor: '#ff6384',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                },
                {
                    label: 'Kelembaban (%)',
                    data: dataKelembaban,
                    borderColor: '#36a2eb',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Waktu',
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nilai',
                    }
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
