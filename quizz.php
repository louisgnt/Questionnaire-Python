<?php 
// Ouvrir une session
session_start();
// Recup les données du fichier json
$json = file_get_contents("questions.json");
$data = json_decode($json);

// Reset
if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
    $_SESSION['correct_answers'] = 0;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si une réponse a été sélectionnée
    if (!isset($_POST['reponse'])) {
        // Afficher un message d'erreur et ne pas procéder à la vérification de la réponse
        $feedback_message = '<p style="color:red;">Veuillez sélectionner une réponse avant de confirmer !</p>';
    } else {
        // réponse sélectionnée
        $submitted_answer = $_POST['reponse'];
        $correct_answer = $data->questions[$_SESSION['question_index']]->reponse;
        // Verifier si c'est la bonne réponse
        if ($submitted_answer == "réponse " . $correct_answer) {
            $_SESSION['correct_answers']++; 
            // Envoyer le feedback correct
            $feedback_message = '<p style="color:green;">Correct!</p>';
        } else {
            // Sinon Envoyer le feedback incorrect
            $feedback_message = '<p style="color:red;">Incorrect!</p>';
        }

        // Verifier si on a fini les questions pour renvoyer vers result.php
        if ($_SESSION['question_index'] < count($data->questions) - 1) {
            $_SESSION['question_index']++;
        } else if ($_SESSION['question_index'] == count($data->questions) - 1) {
            header('Location: result.php');
            exit();
        }
    }
}

// Question index = Premier question, Deuxieme etc
$question_index = $_SESSION['question_index'];

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
        <form name="Questions" method="post">
            <p><?php echo $data->questions[$question_index]->question; ?></p>
            <?php foreach ($data->questions[$question_index]->options as $index => $option): ?>
                <input type="radio" name="reponse" id="reponse<?php echo $index; ?>" value="réponse <?php echo $index; ?>">
                <label for="reponse<?php echo $index; ?>"><?php echo $option; ?></label><br>
            <?php endforeach; ?>
            <?php if (isset($feedback_message)): ?>
                <p><?php echo $feedback_message; ?></p>
            <?php endif; ?>
            <button type="submit">Confirmer</button>
        </form>
    </div>
</div>
</body>
</html>

