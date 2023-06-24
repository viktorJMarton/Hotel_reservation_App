
<?php
    $movies = $db->getActualMoviesArray();
    $moviesJson = json_encode($movies);
?>

<head>
   <title>Hotel-Reservation</title>
   <link rel="stylesheet" href="layouts/styles/welcome.css">
   <link rel="stylesheet" href="layouts/styles/navigation.css">
   <script>
        const movies = <?php echo $moviesJson; ?>;
      
   </script>

 
</head>
<div class="welcome-message">
<div class="welcome-content">
      <p>Cinemassacre</p>
      
      <a href="#" class="btn button" id="my-reservations-button">Foglalásaim</a>
      <a href="concern/logout.php" class="btn button">Kijelentkezés</a>

   </div>
   <div class="one-liner-form">
      <form  method="POST">

         <div class='row'>
            <div class='column'>
               <label for="check-in-date">vetítés napja:</label>   
            </div>
            <div class='column'>
               <label for="movie">Film:</label>  
            </div>
         </div>
         
         <div class='row'>
            <div class='column'>
            <div class='column'>
            <input type="date" id="check-in-date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'); ?>">
         </div>
            </div>
            <div class='column'>
              <select id="movie_selector" name="movie">
                <option value="">Válassz egy filmet</option>
                <script>
                  movies.forEach((movie) => {
                    document.write(`<option value="${movie}">${movie}</option>`);
                  });
                </script>
              </select>
            </div>
         </div>
         <div class="double-row">
           <div class="four-column">
             <input id="scr_screening" type="submit" value="Vetítés keresése">
           </div>
         </div>
      </form>
   </div>
</div>

<script>
     $('#scr_screening').click(function () {
    var selectedDate = $("#check-in-date").val();
    console.log(selectedDate);
    var selectedMovie = $("#movie_selector").val();
    console.log(selectedDate);
    $.ajax({
        url: '../layouts/partials/_main.php',
        method: 'POST',
        data: { date: selectedDate, movie: selectedMovie ,isMain:true }, // Kiválasztott film címe hozzáadva
        success: function (response) {
            window.location.href = 'index.php';
          
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });

});




$('#my-reservations-button').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: 'index.php',
        data: {
                isMain: true
               },
        method: 'POST',
        success: function () {
           
           
            
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
});



   </script>