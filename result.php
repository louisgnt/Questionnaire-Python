<?php
session_start();
$_SESSION['question_index'] = 0;
$session_id = session_id();

// Vérifier si la clé "correct_answers" est définie dans $_SESSION
$correct_answers = isset($_SESSION['correct_answers']) ? $_SESSION['correct_answers'] : 0;

// Lire les données du fichier
$file = 'results.txt';
$fileContent = file_get_contents($file);
$lines = explode("\n", $fileContent);

$found = false;
// Verifier si le session ID a deja joué
foreach ($lines as &$line) {
    $data = explode(",", $line);
    if ($data[0] === $session_id) {
        $data[1] = $correct_answers. '/10';
        $line = implode(",", $data);
        $found = true;
        break;
    }
}

// Sinon ajouter une nouvelle ligne
if (!$found) {
    $lines[] = "$session_id,$correct_answers/10\n";
}


file_put_contents($file, implode("\n", $lines), LOCK_EX);

// Fermer session
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Projet NSI - Quiz Python</title>
    <link rel="stylesheet" href="quizz.css">
</head>
<body>

<div id="app">
    <div>
        <h1><span style="background-color: yellow; padding: 4px;">Python</span><span style="background-color:dodgerblue; padding: 4px;">Quiz</span></h1>
            <p> <?php echo "Tu as " . $correct_answers  . " bonnes réponses"; ?></p>
            <a href="index.html"><button> Home </button></a>
    </div>
</div>
</body>
</html>
