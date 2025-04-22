<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <style>
        body {
            margin: 0;
            font-family: "Montserrat", Arial, sans-serif;
            background: url(../assets/background.jpg) no-repeat fixed;
            background-size: 2000px 700px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #f06292;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: white;
            color: #f06292;
            border: 1px solid #f06292;
        }

        #imagePreview {
            margin-top: 15px;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            display: none;
        }

        .error {
            color: red;
            font-size: 13px;
        }

        .back-button-container {
            padding: 20px;
        }

        .back-button {
            display: inline-block;
            text-align: center;
            text-decoration: none;
            background-color: #f06292;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: white;
            color: #f06292;
            border: 1px solid #f06292;
        }
    </style>
</head>
<body>

<div class="back-button-container">
    <a href="../pages/tables.php" class="back-button">← Retour</a>
</div>

<div class="form-container">
    <form id="eventForm" action="../addEvent.php" method="POST" enctype="multipart/form-data">
        <h2>Add New Event</h2>

        <label>Event Name:</label>
        <input type="text" name="nom_e" id="nom_e">
        <div class="error" id="nom_e_error"></div>

        <label>Date début:</label>
        <input type="datetime-local" name="date_de_e" id="date_de_e">
        <div class="error" id="date_de_e_error"></div>

        <label>Date fin:</label>
        <input type="datetime-local" name="date_f_e" id="date_f_e">
        <div class="error" id="date_f_e_error"></div>

        <label>Location:</label>
        <input type="text" name="lieu_e" id="lieu_e">
        <div class="error" id="lieu_e_error"></div>

        <label>Price:</label>
        <input type="number" name="prix_e" id="prix_e" step="0.01" min="0">
        <div class="error" id="prix_e_error"></div>

        <label>Number total:</label>
        <input type="number" name="nbr_e" id="nbr_e" min="0">
        <div class="error" id="nbr_e_error"></div>

        <label>Category:</label>
        <input type="text" name="category_e" id="category_e">
        <div class="error" id="category_e_error"></div>

        <label>Description:</label>
        <textarea name="desc_e" id="desc_e" rows="4"></textarea>
        <div class="error" id="desc_e_error"></div>

        <label>Event Image:</label>
        <input type="file" name="image" id="imageInput" accept="image/*">
        <div class="error" id="image_error"></div>

        <img id="imagePreview" alt="Image Preview" />

        <button type="submit">Add Event</button>
    </form>
</div>

<script>
    window.onload = function () {
        const now = new Date();
        const localNow = now.toISOString().slice(0, 16);
        const dateInput = document.getElementById('date_de_e');
        dateInput.value = localNow;
        dateInput.min = localNow;
    };

    function validateForm(event) {
        let isValid = true;
        document.querySelectorAll('.error').forEach(e => e.textContent = "");

        const now = new Date();
        const nomE = document.getElementById('nom_e');
        const dateDeE = document.getElementById('date_de_e');
        const dateFeE = document.getElementById('date_f_e');
        const lieuE = document.getElementById('lieu_e');
        const prixE = document.getElementById('prix_e');
        const nbrE = document.getElementById('nbr_e');
        const categoryE = document.getElementById('category_e');
        const descE = document.getElementById('desc_e');
        const imageInput = document.getElementById('imageInput');

        // Nom
        if (nomE.value.trim() === "") {
            document.getElementById('nom_e_error').textContent = "Event name is required.";
            isValid = false;
        } else if (!/^[a-zA-ZÀ-ÿ\s\-]+$/.test(nomE.value)) {
            document.getElementById('nom_e_error').textContent = "Only alphabetic characters allowed.";
            isValid = false;
        }

        // Date début
        if (!dateDeE.value) {
            document.getElementById('date_de_e_error').textContent = "Start date is required.";
            isValid = false;
        } else if (new Date(dateDeE.value) < now) {
            document.getElementById('date_de_e_error').textContent = "Start date must be today or later.";
            isValid = false;
        }

        // Date fin
        if (!dateFeE.value) {
            document.getElementById('date_f_e_error').textContent = "End date is required.";
            isValid = false;
        } else if (new Date(dateFeE.value) <= new Date(dateDeE.value)) {
            document.getElementById('date_f_e_error').textContent = "End date must be after the start date.";
            isValid = false;
        }

        // Lieu
        if (lieuE.value.trim() === "") {
            document.getElementById('lieu_e_error').textContent = "Location is required.";
            isValid = false;
        }

        // Prix
        if (prixE.value === "" || parseFloat(prixE.value) < 0) {
            document.getElementById('prix_e_error').textContent = "Price must be a positive number.";
            isValid = false;
        }

        // Nombre
        if (nbrE.value === "" || parseInt(nbrE.value) <= 0) {
            document.getElementById('nbr_e_error').textContent = "Number of participants must be greater than 0.";
            isValid = false;
        }

        // Catégorie
        if (categoryE.value.trim() === "") {
            document.getElementById('category_e_error').textContent = "Category is required.";
            isValid = false;
        }

        // Description
        if (descE.value.trim() === "") {
            document.getElementById('desc_e_error').textContent = "Description is required.";
            isValid = false;
        }

        // Image
        if (imageInput.files.length === 0) {
            document.getElementById('image_error').textContent = "Please upload an event image.";
            isValid = false;
        } else {
            const file = imageInput.files[0];
            const maxSize = 2 * 1024 * 1024; // 2 MB
            if (!file.type.startsWith("image/")) {
                document.getElementById('image_error').textContent = "Only image files are allowed.";
                isValid = false;
            } else if (file.size > maxSize) {
                document.getElementById('image_error').textContent = "Image must be less than 2MB.";
                isValid = false;
            }
        }

        if (!isValid) {
            event.preventDefault();
        }
    }

    document.getElementById('eventForm').addEventListener('submit', validateForm);

    document.getElementById('imageInput').addEventListener('change', function (event) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.style.display = 'block';
            imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

</body>
</html>
