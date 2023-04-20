<head>
   <title>Hotel-Reservation</title>
   <link rel="stylesheet" href="layouts/styles/main.css">
   <link rel="stylesheet" href="layouts/styles/welcome.css">
</head>
<div class="welcome-message">
   <div class="one-liner-form">
      <form>
         <div class='row'>
            <div class='column'>
               <label for="check-in-date">Check-in date:</label>   
            </div>
            <div class='column'>
               <label for="check-out-date">Check-out date:</label>   
            </div>
            <div class='column'>
               <label for="adults">Number of adults:</label>  
            </div>
            <div class='column'>
               <label for="children">Number of children:</label>
            </div>
         </div>
         
         <div class='row'>
            <div class='column'>
               <input type="date" id="check-in-date" name="check-in-date">
            </div>
            <div class='column'>
               <input type="date" id="check-out-date" name="check-out-date">
            </div>
            <div class='column'>
               <input type="number" id="adults" name="adults" min="1" max="10">
            </div>
            <div class='column'>
               <input type="number" id="children" name="children" min="0" max="10">
            </div>
         </div>
        <div class="double-row"><div class="four-column">  <input type="submit" value="Foglalás">
        </div></div>
       
      </form>
   </div>
   <div class="welcome-content">
      <p>Üdvözlünk szállodánk oldalán!</p>
      <a href="#" class="btn button">Fedezd fel szobáinkat most</a>
   </div>
</div>