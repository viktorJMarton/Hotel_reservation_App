<head>
   <title>Hotel-Reservation</title>
   <link rel="stylesheet" href="layouts/styles/welcome.css">
   <link rel="stylesheet" href="layouts/styles/navigation.css">
   <script>
      const movies = [
        'Movie 1',
        'Movie 2',
        'Movie 3',
        // add more movie names here
      ];
   </script>
</head>
<div class="welcome-message">
<a href="#" class="btn button">Bejelentkezés</a>
<div class="welcome-content">
      <p>Cinemassacre</p>
      <a href="#" class="btn button">Mai vetítések</a>
      <a href="#" class="btn button">Műsor</a>
   </div>
   <div class="one-liner-form">
      <form>
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
               <input type="date" id="check-in-date" name="check-in-date">
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
             <input type="submit" value="Vetítés keresése">
           </div>
         </div>
      </form>
   </div>
</div>
