<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mushaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri+Quran&family=Aref+Ruqaa&display=swap" rel="stylesheet">
   
    <style>
        body {
            direction: rtl;
            font-family: 'Amiri Quran', serif;
            background-color:  #e4d995;
            color: #333;
        }

        h5,
        p,
        option,
        select {
            font-family: 'Amiri Quran', serif;
            text-align: center;
        }

        .container {
            padding: 40px;
            margin-top: 30px;
            background-color: #fff8e1;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .form-select {
            background-color: #f9f5e6;
            font-size: 1.2rem;
            padding: 12px;
            border: 2px solid #d4af37;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }

        .form-select:focus {
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .card {
            background-color: #e2dcb1;
            border: 2px solid #d4af37;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            background-color: #f9f5e6;
            padding: 20px;
            text-align: right;
        }

        h5 {
            color: #333;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.2rem;
            color: #666;
        }

        hr {
            border-top: 2px solid #e0c48f;
            margin: 10px 0;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .card-body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    @php
    $languages = [
        'Arabic',
        'Amharic',
        'Azerbaijani',
        'Berber',
        'Bengali',
        'Czech',
        'German',
        'Dhivehi',
        'English',
        'Spanish',
        'Persian',
        'French',
        'Hausa',
        'Hindi',
        'Indonesian',
        'Italian',
        'Japanese',
        'Korean',
        'Kurdish',
        'Malayalam',
        'Dutch',
        'Norwegian',
        'Polish',
        'Pashto',
        'Portuguese',
        'Romanian',
        'Russian',
        'Sindhi',
        'Somali',
        'Albanian',
        'Swedish',
        'Swahili',
        'Tamil',
        'Tajik',
        'Thai',
        'Turkish',
        'Tatar',
        'Uyghur',
        'Urdu',
        'Uzbek',
    ];
@endphp

<div class="container">
    <select class="form-select" aria-label="Default select example" id="languageSelect">
        @foreach ($lang as $index => $language)
            <option value="{{ $language }}">{{ $languages[$index] }}</option>
        @endforeach
    </select>
    <br>
    <select class="form-select" aria-label="Default select example" id="languageData">
    </select>
</div>

<div class="container mt-4">
    <!-- Bismillah Section -->
    <div class="row">
        <div class="col-md-12 mb-4 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">بِسْمِ ٱللَّهِ ٱلرَّحْمَـٰنِ ٱلرَّحِيمِ</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Ayah Cards Section -->
   
    <div class="row" id="ayahCardsContainer">
        <!-- Ayah cards will be dynamically injected here -->
        @foreach ($collection as $index => $item)
            <div class="col-md-12 mb-4 col-sm-12">
                <div class="card">
                    <div class="card-body text-end">
                        <p class="card-text"> Ayah No {{ $index + 1 }} | آیت نمبر {{ $index + 1 }}</p>
                        <hr>
                        <h5 class="card-title">{{ $item['text'] }}</h5>
                        <br>
                       

                        <div id="languageDataaudio_{{ $index }}"></div>
                        <div id="languageData1_{{ $index }}"></div>
                          <!-- Audio player for each ayah -->
            <audio controls style="width: 100%";>
                <source src="{{ $audio[$index]['audio'] }}" type="audio/mp3">
                
            </audio>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const languageSelect = document.getElementById('languageSelect');
        const languageData = document.getElementById('languageData');
        const ayahCardsContainer = document.getElementById('ayahCardsContainer');

        languageSelect.addEventListener('change', function() {
            const selectedLanguage = languageSelect.value;
            fetchLanguageData(selectedLanguage);
        });

        // Fetch data for the default selected language on page load
        fetchLanguageData(languageSelect.value);

        function fetchLanguageData(languageCode) {
            fetch(`https://api.alquran.cloud/v1/edition/language/${languageCode}`)
                .then(response => response.json())
                .then(data => {
                    const editions = data.data.map(edition =>
                        `<option value="${edition.identifier}">${edition.englishName} | ${edition.name}</option>`
                    ).join('');
                    languageData.innerHTML = editions ||
                        '<option>No data available for this language.</option>';

                    // Automatically fetch data for the first edition
                    if (data.data.length > 0) {
                        fetchSurahData(data.data[0].identifier);
                    }
                })
                .catch(error => {
                    console.error('Error fetching language data:', error);
                    languageData.innerHTML = '<option>Failed to load language data.</option>';
                });

            languageData.addEventListener('change', function() {
                fetchSurahData(languageData.value);
            });
        }

        function fetchSurahData(editionIdentifier) {
            const surahNumber = {{ $snum }};
            fetch(`https://api.alquran.cloud/v1/surah/${surahNumber}/${editionIdentifier}`)
                .then(response => response.json())
                .then(data => {
                    data.data.ayahs.forEach((ayah, index) => {
                        const audioElement = ayah.audio ?
                            `<center><audio controls><source src="${ayah.audio}" type="audio/mp3"></audio></center>` :
                            '<p>No Audio</p>';
                        const translationElement = ayah.text ?
                            `<p>${ayah.text}</p>` :
                            '<p>No translation available</p>';

                        // document.getElementById(`languageDataaudio_${index}`).innerHTML =
                        //      audioElement;
                        // document.getElementById(`languageData1_${index}`).innerHTML =
                        // translationElement;
                        if (audioElement != '<p>No Audio</p>') {

                            document.getElementById(`languageData1_${index}`).innerHTML =
                                " ";
                            document.getElementById(`languageDataaudio_${index}`).innerHTML =
                                audioElement;
                        } else {
                            document.getElementById(`languageData1_${index}`).innerHTML =
                                translationElement;
                        }

                    });
                })
                .catch(error => {
                    console.error('Error fetching Surah data:', error);
                    // Show error message or handle error condition
                });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
</body>

</html>