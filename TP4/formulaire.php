<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 - Formulaire d'inscription</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #2c3e50;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        input:focus {
            outline: none;
            border-color: #3498db;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: #1e8449;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 Formulaire d'inscription</h2>

        <form action="traitement.php" method="POST">

            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="exemple@email.com">
            </div>

            <button type="submit" class="btn-submit">Envoyer</button>

        </form>
    </div>
</body>
</html>
