<?php 
session_start();
$json = file_get_contents("questions.json");
$data = json_decode($json);


if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
    $_SESSION['correct_answers'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $submitted_answer = $_POST['reponse'];
    $correct_answer = $data->questions[$_SESSION['question_index']]->reponse;
    
    if ($submitted_answer == "réponse " . $correct_answer) {
        $_SESSION['correct_answers']++; 
        $feedback_message = '<p style="color=green;">Correct!</p>';
    } else {
        $feedback_message = '<p style="color=red;">Incorrect!</p>';
    }
    
    if ($_SESSION['question_index'] < count($data->questions) - 1) {
        $_SESSION['question_index']++;
    }else if ($_SESSION['question_index'] == count($data->questions) - 1) {
        header('Location: result.php');
        exit();
    }
}

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
