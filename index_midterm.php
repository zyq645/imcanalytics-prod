<?php
//MIDTERM ADDITIONS - DATABASE CONNECTION
// Create Database connection
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");

// Check Database connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 
	if(isset($_POST['name'])) {




	
//MIDTERM ADDITIONS - EXPERT TIP - AVOID POSTING LOOP
//Student Comment: Initial variable UNAME, GREETING and CARRCOUNT for furture reference first

	 if(isset($_POST['cookie'])) {
	  $COOKIELOAD=1; }
	  
		 $CARTCOUNT = 0;
	     $UNAME = ($_POST['name']);
		 $GREETING = 'Welcome back '. $UNAME.'.';
		 
//MIDTERM ADDITIONS - SQL SELECT TO GET USER DETAILS	
// Student Comment: Using SQL to fetch back-end consumer data. It first establish a mysql query that extract
// all the data related to the user who logs on. And assign the exact value of CARTCOUNT, PREF and
// LATEST to replace the initial value

		 $search1 = mysqli_query($con,"SELECT * FROM `Customer` WHERE UID = '". $UNAME ."'");
		 if(mysqli_num_rows($search1) > 0){
		 while($row = mysqli_fetch_array($search1)) {
		  $CARTCOUNT = $row[CartItems];
		  $PREF = $row[Pref];
		  $LATEST = $row[LastCart];
		  }
		  
		  
//MIDTERM ADDITIONS - LOGIC TO SET BOOKS
//Student Comment: Using SQL to fetch beack-end book info and use if loop to match book infor. It begins with creating 
//a query that fetch all the books info in the selected category. The next step is examine the status of the logged-in 
//consumer. If he/she has recently place items in the cart, it will assign n equals to 2 and build a new query to take 
//and display the info of the first book from query3. (Query 3 take all books that are recently placed) However, if 
//he/she doesn't place anything, it will have 2 situations and n will be assigned as 1. If the book is not lastest placed, customers will see the 
//info this book in the category. But if this book is recently placed, the system will show the book with id of 100,
//200, 300 and 400



	      $search2 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE CatID = '". $PREF ."'");
		  if($LATEST != 0) {
		   $n=2;
		   $search3 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid = '". $LATEST ."'");
	       $BOOKID1=$LATEST;
		   while($row = mysqli_fetch_array($search3)) {
		   ${"BOOKPIC1"} = $row[Image];
		   ${"BOOKTITLE1"} = $row[Title];
		   ${"BOOKAUTH1"} = $row[Author];
		   ${"BOOKDESC1"} = $row[Description];
		   ${"BOOKPRICE1"} = $row[Price];
		   }
		  } else 
		  { $n=1; 
		  }
		  while($row = mysqli_fetch_array($search2)) {
		  if($row[bid] != $LATEST){
	       ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];
		   $n++;
		   }
		    }
		   } else {
		    $n=1;
		    $search4 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid in (100,200,300,400)");
           while($row = mysqli_fetch_array($search4)) {
		   ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];	
           $n++;
		   }		   
      }
     }	  else { 
		 $GREETING = 'Welcome Guest. <a href="#" class="my_popup_open">Log on</a> for recommendations.';
		 
//MIDTERM ADDITIONS - SET BOOKS FOR LOGGED OUT VISITORS
//Student Comment: Show the info of the default books with id 100,200,300,400 to logged out customers
	
		 $n=1;
		 $search4 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid in (100,200,300,400)");
           while($row = mysqli_fetch_array($search4)) {
		   ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];	
           $n++;
		   }		   

		 }
		 
		 
?>

<html>

 <head>
 


 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="http://www.imcanalytics.com/js/jquery.popupoverlay.js"></script>
 <style>
 section {
    width: 90%;
    height: 200px;
    margin: auto;
    padding: 10px;
}

#one {
  float:left; 
  margin-right:20px;
  width:40%;
  border:1px solid;
  min-height:220px;
}

#two { 
  overflow:hidden;
  width:40%;
  border:1px solid;
  min-height:220px;
}

#three {
  float:left; 
  margin-top:10px;
  margin-right:20px;
  width:40%;
  border:1px solid;
  min-height:220px;
}

#four { 
  overflow:hidden;
  margin-top:10px;
  width:40%;
  border:1px solid;
  min-height:220px;
}

@media screen and (max-width: 400px) {
   #one { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }
  
  #two { 
  background-color: white;
  overflow:hidden;
  width:auto;
  margin-bottom:10px;
  min-height:170px;
}

   #three { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }
  
  #four { 
  background-color: white;
  overflow:hidden;
  width:auto;
  min-height:170px;
}

}
</style>

<script>
    
    $(document).ready(function() {

      // Initialize the plugin
	 
      $('#my_popup').popup({  
	   transition: 'all 0.3s',
       scrolllock: true // optional
   });

      $('#bookdeets').popup({  
	   transition: 'all 0.3s',
       scrolllock: true // optional
   });
   
});

   $.fn.DeetsBox = function(bid) {
        if(bid == '1'){	

//MIDTERM ADDITIONS - NEW VARIABLES AND CONDITIONS
//Student Comment: This is a Java code. It first creates 2 new variable: book name and book price
//If the book id is 1, it will returns the name and price of book1.
//And it will put name and price in pop-up window and bookshelf.
//If the book is already in the cart, the reminder will be purchase; otherwise it will be learn more.
//The same logic applies to book2-4.




		var bookname = $( "#book1" ).val();
		var bookprice = $( "#book1price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); 
		$("#bookshelf").val('1'); 
		 var fromcart = $( "#iscart" ).val();
		 if(fromcart != 0){
		 
		 $("#deetcta").text('Purchase'); }
		}
		else if(bid == '2'){
		var bookname = $( "#book2" ).val();
		var bookprice = $( "#book2price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); 
		$("#bookshelf").val('2'); 
	// Student Comment: Pop-Up for book2
		 var fromcart = $( "#iscart" ).val();
		 if(fromcart != 0){
		 
		 $("#deetcta").text('Purchase'); }
		
		}
			else if(bid == '3'){
		var bookname = $( "#book3" ).val();
		var bookprice = $( "#book3price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); 
		$("#bookshelf").val('3'); 
		
	// Student Comment: Pop-Up for book3
		 var fromcart = $( "#iscart" ).val();
		 if(fromcart != 0){
		 
		 $("#deetcta").text('Purchase'); }
		}
			else if(bid == '4'){
		var bookname = $( "#book4" ).val();
		var bookprice = $( "#book4price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); 
		$("#bookshelf").val('4'); 
	// Student Comment: Pop-Up for book4
		 var fromcart = $( "#iscart" ).val();
		 if(fromcart != 0){
		 
		 $("#deetcta").text('Purchase'); }
		}
		$('#bookdeets').popup('show');
    };
	


</script>

<script language="JavaScript">

//TWO FUNCTIONS TO SET THE COOKIE
//Student Comment: This is Java Script. Define mixCookie function by setting the name to cookie

function mixCookie() {

 	    var name = document.forms["form1"]["name"].value;

        bakeCookie("readuser", name, 365);
			
   }
   
//Student Comment:This is Java Script. Define bakeCookie function by setting the created time, expired time and documented format to cookie  

function bakeCookie(cname, cvalue1, cvalue2, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue1 + "%-" + cvalue2 + ";" + expires;
}

//TWO FUNCTIONS TO GET THE COOKIE
//Student Comment: This is Java Script. 

function checkCookie() {
    var userdeets = getCookie("readuser");
    
//MIDTERM ADDITIONS - 'CHECKFIRST' VARIABLE - FOR 'IF' BELOW
//Student Comment: The function fo "checkfirst" is to see whether we have cookie and info about 
//the logged customer. If it is not the first time the customer visit and log (we examine this through if statement), 
//it will read the stored cookie and make personalized change for the customer.


	var checkfirst = document.getElementById('firstload').value;
	
	
	
//Student Comment: if the entered name is no missing, the system will return the reformatted, splited
//name and personalized greeting message. If it's missing, it will return blank.
    if (userdeets != "") {
	    var deets = userdeets.split("%-");
		var user = deets[0];
		
//MIDTERM ADDITIONS - NEW NESTED 'IF' LOGIC TO POST USERNAME TO PHP TO CHECK FOR DETAILS THROUGH SQL	
//Student Comment: The function of this if statement has been explained in ROW 307-309. If checkfirst is 
//not equal to 1, it means it is not the first the customer log and we have info about this person and 
//we can make personalized changes.	
		 if(checkfirst != 1){
		  
		  post('index.php',{name:user,cookie:yes});
		  
		 } else { greeting.innerHTML = 'Welcome ' + user; }
	     
  } else { return "";}
}

//Student Comment: This is a JAVA Script. It helps format user name.

function getCookie(cname) {

    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

<!--MIDTERM ADDITIONS - FUNCTION TO DELETE COOKIE-->


function drop_cookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  window.location.href = window.location.pathname;
}

<!--MIDTERM ADDITIONS - FUNCTION TO POST FROM JS -->

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}


</script>

<!--STUDENT COMMENT: GOOGLE ANALYTICS TRACKING CODE -->

 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68559037-1', 'auto');
  ga('send', 'pageview');

</script>



 </head>
 
 
 <body  onload="checkCookie()">

 
 <div style="width:100%; height:25%; background-color:#57585A;">
 <img src="img/ic1.jpg" style="max-height: 100%;">
 
<!--MIDTERM ADDITIONS - LOG-OUT LINK & LOGIC FOR VISITOR LOGGED STATE. CART NOW A LINK.--> 

<?php if(isset($_POST['name'])) { ?>
<!-- Student Comment: It is not meaningful to track any "LOG OUT" event, so I didn't add any tracking to this event -->	

    <div style="float:right; margin-right:50px;margin-top:10px; color:white;"> <a href="#" style="color:white;" onclick="drop_cookie('readuser');">Log Out</a> </div>
	
	<div style="float:right; margin-right:75px;margin-top:10px; color:white;"> 
	
<!-- Student Comment: Add tracking code to Cart, tracking everytime the cart is activated by customer. The category
	 of this action is "convert" and is called "cart_click". I embed a php code inside of the ga statement. So it 
	 will return the user name of people who log on -->	
	 
	 <a href="#" style="color:white;" onClick="ga('send', 'event', 'convert', 'cart_click', '<?php echo $UNAME ?>');">Cart: <?php echo $CARTCOUNT ?></a>
	 </div>
 <?php } ?>
 </div>
 <div style="margin-top:10px; margin-bottom:10px; font-size: 130%; color:#57585A;">
 <strong>Icculus Media: For All Your Fictional Needs</strong>
 </div>
 

 <div id="greeting"> <?php echo $GREETING ?> </div>
 
 <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED IN NEW CHECKCOOKIE LOGIC -->
 <!--Student Comment: The following two rows tell us whether this cookie about this person
 and whether the book is carted-->
 
 <input type="hidden" id="firstload" value="<?php echo $COOKIELOAD ?>">
 
  <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED FOR BOOK1 CTA -->
 <input type="hidden" id="iscart" value="<?php echo $LATEST ?>">
 
 

 
 <div id="cta1"> Please browse our options:</div>
 <section>
 <!--Student Comment: Slot1-->
 <!--Student Comment: Set propertities of the section-->
 <div id="one" style="padding:10px;"> 
 <!--Student Comment: Use PHP to get book1 info-->
	<?php echo $BOOK1; ?>
 <!--Student Comment: Use PHP to get book1 pic. Change PHP VARIABLE TO BOOKPIC1 TO SPECIFY. The same logics applies to other slot-->
	<img src="img/<?php echo $BOOKPIC1 ?>" style="float:left; margin-right:6px; height: 100px;">
	
<!-- MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC of Book1 in the pop up window via embedding php language in html. 
Specify id and value to book1 and book1price. The same logics applies to other books-->
    <input type="hidden" id="book1" value="<?php echo $BOOKTITLE1 ?>">
	<input type="hidden" id="book1price" value="<?php echo $BOOKPRICE1 ?>">

<!-- Student Comment: ADDED booki title, author, description via embedding php language and specifying to book1. The same logics applies to other books-->	
	<strong><?php echo $BOOKTITLE1 ?></strong><p>
	by <?php echo $BOOKAUTH1 ?> <p>
	<?php echo $BOOKDESC1 ?>
	<p>
	<?php if($LATEST != 0){ ?>
	
	
<!-- Student Comment: Add tracking code to the purchase botton and also
	activate the deetsbox function by adding ";". Label Book name to G.A-->
	<input type="button" value="Purchase" id="book1button" onClick="ga('send', 'event', 'convert', 'purchase', document.getElementById('book1').value); $(this).DeetsBox(1);">
	<?php } else { ?>
	<input type="button" value="Learn More" id="book1button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book1').value); $(this).DeetsBox(1);">
	<?php } ?>
	</div>
	
<!-- Student Comment: Modify Slot2 -->
 <div id="two" style="padding:10px;">
<!--Student Comment: Use PHP to get book2 info-->
	<?php echo $BOOK2; ?>
<!-- Student Comment: Use PHP language to extract and display pic related to Book2 from backstage dataset-->	
	<img src="img/<?php echo $BOOKPIC2 ?>" style="float:left; margin-right:6px; height: 100px;">
<!-- Student Comment - Use PHP language to added bookprice. made book dynamic for slot2  in pop up window from backstage dataset -->
    <input type="hidden" id="book2" value="<?php echo $BOOKTITLE2 ?>">
    <input type="hidden" id="book2price" value="<?php echo $BOOKPRICE2 ?>">
    
<!-- Student Comment - Use PHP to take Slot2 Title from backstage dataset-->
	<strong><?php echo $BOOKTITLE2 ?></strong><p>
<!-- Student Comment - Use PHP to added Slot2 Author from backstage dataset-->
	by <?php echo $BOOKAUTH2 ?><p>
<!-- Student Comment - Use PHP to added Slot2 Description from backstage dataset-->
	<?php echo $BOOKDESC2 ?>
	<p>
<!-- Student Comment: Add tracking code to the learn more botton Label Book name to G.A -->
	<input type="button" value="Learn More" id="book2button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book2').value); $(this).DeetsBox(2);">
	</div>
	
	
<!-- Student Comment: Modify Slot3 -->	
 <div id="three" style="padding:10px;">
<!--Student Comment: Use PHP to get book3 info-->
	<?php echo $BOOK2; ?>
	<?php echo $BOOK3; ?>
<!-- Student Comment: Use PHP language to extract and display pic related to Book3 -->	
	<img src="img/<?php echo $BOOKPIC3 ?>" style="float:left; margin-right:6px; height: 100px;">
<!-- Student Comment - Added bookprice. made book dynamic for slot3  in the pop up window-->
    <input type="hidden" id="book3" value="<?php echo $BOOKTITLE3 ?>">
    <input type="hidden" id="book3price" value="<?php echo $BOOKPRICE3 ?>">
    
<!-- Student Comment - Blod Slot3 Title -->
	<strong><?php echo $BOOKTITLE3 ?></strong><p>
<!-- Student Comment - Added Slot3 Author -->
	by <?php echo $BOOKAUTH3 ?><p>
<!-- Student Comment - Added Slot3 Description -->
	<?php echo $BOOKDESC3 ?>
	<p>
<!-- Student Comment: Add tracking code to the learn more botton Label Book name to G.A-->
	<input type="button" value="Learn More" id="book3button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book3').value); $(this).DeetsBox(3);">
	</div>
    
    
    
    
<!-- MIDTERM ADDITIONS - PHP SO THAT DISPLAY DEPENDS ON CART OR NOT -->	
<?php 
if($n > 4){ ?>
 <div id="four" style="padding:10px;">
 <!--Student Comment: Use PHP to get book4 info-->
	<?php echo $BOOK4; ?>
<!-- Student Comment: Use PHP language to extract and display pic related to Book4 -->	
	<img src="img/<?php echo $BOOKPIC4 ?>" style="float:left; margin-right:6px; height: 100px;">
<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
<!-- Student Comment - Added bookprice. made book dynamic for slot4 -->
    <input type="hidden" id="book4" value="<?php echo $BOOKTITLE4 ?>">
    <input type="hidden" id="book4price" value="<?php echo $BOOKPRICE4 ?>">
<!-- Student Comment - Blod Slot4 Title -->
	<strong><?php echo $BOOKTITLE4 ?></strong><p>
<!-- Student Comment - Added Slot4 Author -->
	by <?php echo $BOOKAUTH4 ?><p>
<!-- Student Comment - Added Slot4 Description -->
	<?php echo $BOOKDESC4 ?>
	<p>
<!-- Student Comment: Add tracking code to the learn more botton Label Book name to G.A-->
	<input type="button" value="Learn More" id="book4button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book4').value); $(this).DeetsBox(4);">
	</div>
	<?php } else { ?>
	<div id="four" style="padding:10px;"></div>
	<?php } ?>
	
</section>

	<div id="my_popup" style = "background-color: white; display: none; padding: 20px;">
    <form name="form1" action="#" method="post">
	     <div>Please enter your name:</div>
	
    <input name="name" id="uname" type="text" /><p>
	<input type="submit" onclick="mixCookie();" value="Log In"/> <p>
	</form>
	</div>
	

	<div id="bookdeets" style = "background-color: white; display: none; padding: 20px;">
	<div id="showbookdeets"></div>
    <input type="hidden" id="bookshelf"  value="0">
	
<!--MIDTERM ADDITIONS - CHANGED TO BUTTON TO CLOSE-->
<!-- Student Comment: Add tracking code for every time customer add an item to the cart. Label # of item to G.A-->

	<button id="deetcta" class="bookdeets_close"  onClick="ga('send', 'event', 'convert', 'cart_add', document.getElementById('bookshelf').value)";/>Add to Cart</button> <p>
	</div>

 </body>
 </html>
