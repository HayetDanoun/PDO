<?php
    require_once '_connec.php';

    $pdo = new PDO(DNS,USER,PASSWORD);

    $query = "SELECT * FROM friend ";
    $statement = $pdo->query($query);
    $tabObjFriends = $statement->fetchAll(PDO::FETCH_OBJ);

    if(!empty($tabObjFriends)){
        echo 'Voici la liste de mes amis <br>';
        //var_dump($tabObjFriends);       
        echo '<ul>';
        foreach($tabObjFriends as $value){
            echo '<li>' . $value->firstname . ' ' . $value->lastname . '</li>'; 
        }
        echo '</ul>';
    }
?>
<h1>Ajouter un nouveau ami</h1>
<form method='post' action="index.php">
    <div>
        <label for='firstname'>Firstname* :</label>
        <input name='firstname' required>
    </div>
    <div>
        <label for='lastname'>Lastname* :</label>
        <input name='lastname' required>
    </div>
    <button type='submit'>Envoyer</button>
</form>
<?php
    $errors = [];
    if(!empty($_POST)){
        
        if(isset($_POST['firstname']) )
                if(strlen($_POST['firstname']) > 45) $errors[] = 'Le champ Firstname doit faire moins de 45 caracteres';
                if(empty($_POST['firstname']) || trim($_POST['firstname']) === "")  $errors[] = 'Le champ Firstname doit etre rempli';
        if(isset($_POST['lastname']) )
                if(strlen($_POST['lastname']) > 45) $errors[] = 'Le champ Lastname doit faire moins de 45 caracteres';
                if(empty($_POST['lastname']) || trim($_POST['lastname']) === "")  $errors[] = 'Le champ Lastname doit etre rempli';

        //var_dump($errors);
        foreach($errors as $value){
            echo $value . '<br>' ;
        }
        if(empty($errors)){

            $query = 'INSERT INTO friend (firstname,lastname) VALUES (:firstname,:lastname)';
            $statement = $pdo->prepare($query);

            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];

            $statement->bindValue(':firstname',$firstname);
            $statement->bindValue(':lastname',$lastname);

            $statement->execute();

            echo 'Felicitation ' . $firstname . ' ' . $lastname . ' est desormais votre ami !';
        }

    }
?>
