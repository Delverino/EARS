<!DOCTYPE html>
<?php require 'test.php' ?>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta keyword="Virtual Pet, Frog, Would You Rather, Game">
        <title>Would You Rather | Virtual Frog</title>
        <link rel="stylesheet" href="style10.css">
        <link rel="stylesheet" href="style20.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="icon" href="images/icon.png" type="image/png">
        <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
        <style>
            #speech-bubble{
                background: white;
                font-size: 60px;
                border-radius: 20px;
                border: solid 3px black;
                width:330px;
                padding: 20px;
                font-size: 30px;
                margin-left:auto;
                margin-right:auto;
                transition: color 0.2s linear;
                text-align: left;
                position: relative;
            }
            .container {
                position: relative;
                width: 250px;
            }
            #frog-body{
                display: block;
                width: inherit;
                height: auto;
                transition: .5s ease;
                backface-visibility: hidden;
                margin-left:auto;
                margin-right:auto;
                margin-top:40px;
            }
            #hidden{
                color: white;

            }
            /* #contact{
              background-color: white;
            } */
            #contact{
                background-color: white;
                background-clip: padding-box;
            }

            .prompt-wrapper {
              text-align: center;
              vertical-align: middle;
              margin-top:100px;
            }
            
            .prompt {
              display: inline-block;
              vertical-align: middle;
            }
            
            input[type=submit], #joke, #joke2 {
              width: 100px;
              padding: 10px;
              margin-left: 50px;
              margin-right: 50px;
              font-size: 18px !important;
              border-radius: 10px;
              border: none;
              background-color: #16631f;
              transition-duration: 0.4s;
              color: white;
              padding: 12px;}
            
            
            input[type=submit]:hover, #joke:hover, #joke2:hover { 
              background-color: #e6ca2e; 
              color: #16631f; 
              font-weight: bold;
            }
            
            input[type=submit]:active, #joke:active, #joke2:active{ 
              background-color: white; 
              color: #16631f;
              font-weight: bold;
             }
             
             #highlight {
               background-color: #f5e487;
             }
             
             #op1 { display: none; }
             #op2 { display: none; }
             
             #speech-bubble:hover {
               color: rgba(0, 0, 0, 0.2);
             }
             #next-prompt{ 
               visibility: hidden;
               position: absolute;
               opacity: 0;
               width: 170px;
               transition-duration: 0.4s;
               top: 50%;  
              left: 50%; 
              transform: translate(-50%, -50%);
              vertical-align: middle;
              padding: 10px;
              font-size: 18px !important;
              border-radius: 10px;
              border: none;
              background-color: #e6ca2e;
              transition-duration: 0.4s;
              color: #16631f;
               
             }
             #speech-bubble:hover #next-prompt {
               /* display: block; */
               visibility: visible;
               opacity: 1;

               
             }

             #joke, #joke2 {
               width:150px;
               visibility: hidden;
               margin-left:auto;
               margin-right:auto;
               display: block;
               margin-top: 60px;
              }
              #joke2{
                width:170px;
                margin-top: 20px;

              }
             
             #next-prompt:hover { 
               background-color: #16631f; 
               color: #e6ca2e; 
               font-weight: bold;
               cursor: pointer;
             }
             
             #next-prompt:active { 
               background-color: white; 
               color: #16631f;
               font-weight: bold;
              }
             
             #pwrap {
               position: absolute;
               height: 100px;
               vertical-align: middle;
              margin: 0;
              top: 50%;
              left: 50%;
              -ms-transform: translate(-50%, -50%);
              transform: translate(-50%, -50%);
             }
             
             
             @media screen and (max-width: 900px) {
               .wrapper2 {
                 width: 400px;
                 margin: auto;
               }
               
               #op1 {
                 margin-bottom: 15px;
               }
               
               #op2 {
                 margin-top: 15px;
               }
               
               #frog-body {
                 width: 150px;
               }
               
               ul {
                 display: none;
                 
               }
               
               .share-buttons a {
                   margin: 0 10px;
               }
               
             }
             
             @media screen and (max-width: 400px) {
               
               .wrapper2 {
                 width: 98%;
               }
               
               #speech-bubble {
                 width: 80%;
               }
             }
             
             
            
        </style>

        <script>
            

            const API_URL = "https://api.aakhilv.me/fun/wyr";
            const JOKE_URL = "https://v2.jokeapi.dev/joke/Programming?blacklistFlags=nsfw,racist,sexist,explicit,political,religious&type=single"
            const EDGECASE_1 = "Would you have an Alien friend or a Superhero friend?";
            const EDGECASE_2 = "If you had to give up one thing for the rest of your life, would it be brushing your hair or brushing your teeth?";
            const EDGECASE_3 = "Would you feel worse if no one showed up to your wedding or to your funeral?";
            var prompt;
            var option1;
            var option2;
            var ready = false;
            var called = false;

            <?php 
            
            if(isset($_POST['prompt'])) {
              echo "ready = true; 
                    $('#op1').hide(); 
                    $('#op2').hide(); 
                    var donePrint = false;
                    froggyTalk('{$message}', 'joke');"; 
            }
            
            ?>

            async function getPrompt(URL)
            {
              const response = await fetch(URL);
              prompt = await response.json();
              return prompt;
            }
            
            function printPrompt(q, wyr_or_joke)
            {
              
              document.getElementById("prompt").value = q;
              if(wyr_or_joke == 'wyr'){

                  q = JSON.stringify(q);
                  q = q.slice(2, -2);
                  
                  wyr = "would you rather ";
                  or = " or ";
                  //info = { prompt: q; option1: "",  option1: ""};
        
                // most prompts are in the form "Would you rather [ option 1 ] or [ option 2 ]?"
                // however there are annoyingly three exceptions which we need to account for
                  if (q == EDGECASE_1) {
                    option1 = "an Alien friend";
                    option2 = "a Superhero friend";
                  } else if (q == EDGECASE_2) {
                    option1 = "brushing your hair";
                    option2 = "brushing your teeth";
                  } else if (q == EDGECASE_3) {
                    option1 = "no one showed up to your wedding";
                    option2 = "to your funeral";
                  } else {
                    start_op1 = q.toLowerCase().indexOf(wyr) + wyr.length;
                    end_op1 = q.toLowerCase().indexOf(or);
                    
                    start_op2 = q.toLowerCase().indexOf(or) + or.length;
                    end_op2 = q.length - 1;
                    
                    option1 = q.substring(start_op1, end_op1);
                    option2 = q.substring(start_op2, end_op2);
                  }
                  
                  console.log("option 1: " + option1);
                  console.log("option 2: " + option2);
              } else {
                  q = q.joke;
              }
          
              
              froggyTalk(q, wyr_or_joke);
            
              
            }
            
            function froggyTalk(q, wyr_or_joke)
            {
              
              const lettersPerAnim = 5;
              const textFrequency = 40
              for(let i = 0; i < q.length; i++){
                  setTimeout(
                      function(){
                          $("#shown").html(q.substring(0,i+1));
                          $("#hidden").html(q.substring(i+1,q.length));
                          if(i%(lettersPerAnim*2) == 0 || i+1 == q.length){
                              $("#frog-body").attr("src", "images/frog-body-with-mouth.png");
                          } else if (i%lettersPerAnim == 0) {
                              $("#frog-body").attr("src", "images/frog-body.png");
                          }
                            
                          if (i == q.length - 1) {
                            ready = true;
                            eventListener(wyr_or_joke)
                          }
                      }, 
                  i*textFrequency
                
                )
          
              }
              
            }
            
            function eventListener(wyr_or_joke)
            {
              
              if (wyr_or_joke == "wyr"){
                called = false;
                button1 = document.getElementById("op1");
                button2 = document.getElementById("op2");
                
                button1.style.display = "inline-block";
                button2.style.display = "inline-block";
                
                button1.addEventListener("mouseover", highlightOption);
                button2.addEventListener("mouseover", highlightOption);
                button1.addEventListener("mouseout", unhighlightOption);
                button2.addEventListener("mouseout", unhighlightOption);
              } 
              console.log("about to change attr")
              $("#joke").show();
              $("#joke").css("visibility", "inherit");
              $("#joke2").show();
              $("#joke2").css("visibility", "inherit");
              
          
            }
            
            function highlightOption()
            {
                start = "";
                option = "";
                end = "";
              
                prompt = prompt.toString();
                if (this.value == "Option 1") {
                  start = prompt.substring(0, prompt.indexOf(option1));
                  option = option1;
                  end = prompt.substring(prompt.indexOf(option1) + option1.length);
                } else {
                  start = prompt.substring(0, prompt.indexOf(option2));
                  option = option2;
                  end = prompt.substring(prompt.indexOf(option2) + option2.length);
                }
                
                span = document.getElementById("shown");
                
                span.innerHTML = start + "<span id='highlight'>" + option + "</span>" + end;
                
            }
            
            function unhighlightOption()
            {
              document.getElementById("shown").innerHTML = prompt;
            }
         	
          
            if (ready == false) {
              newPrompt('wyr');
            } else {
              $("#joke").hide();
              $("#joke2").hide();
              $("#op1").hide();
              $("#op2").hide();
            }
            
        
      
            
            function newPrompt(wyr_or_joke) 
            {
              ready = false;
              $("#joke").hide();
              $("#joke2").hide();
              $("#op1").hide();
              $("#op2").hide();
              getPrompt((wyr_or_joke == 'joke') ? JOKE_URL : API_URL)
                .then(prompt => printPrompt(prompt, wyr_or_joke))
                .catch(error => console.log("Caught exception: " + error));
            }
            
            /*********/
    
        </script>
    </head>



    <body>
        <ul>
            <li><a href="contact.html" id="contact">Contact Us</a></li>
        </ul>
        
        <div class="share-buttons">
            <a href="#" id="facebook" target="_blank">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="#" id="twitter" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" id="pinterest" target="_blank">
                <i class="fab fa-pinterest"></i>
            </a>
            <a href="#" id="linkedin" target="_blank">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="#" id="whatsapp" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        
     <form action="" method="post">
        <input type="hidden" name="prompt" id="prompt">
        <!-- Display the question -->
        <div class="prompt-wrapper">
          <div class="wrapper2">
            <input class="prompt" id="op1" type="submit" name="option1" value="Option 1">
            <div class="prompt" id="speech-bubble"><div id="pwrap"><input class="prompt" id="next-prompt" type="button" name="diffprompt" value="Different Prompt" onclick="newPrompt('wyr')"></div><span id="shown">Would you rather...</span><span id="hidden">her asdfasdf asdf</span></div>
            <input class="prompt" id="op2" type="submit" name="option2" value="Option 2">

          </div>
        </div>
        <a class="container" title="Frog Cartoon Picture from https://clipartmag.com/frog-cartoon-picture">
            <img src="images/frog-body.png" id="frog-body" /></a>
    <!-- TODO currently after you tell a joke, if you scroll over the "option 1 option 2 buttons it breaks" -->
            <input type="button" class="prompt" id="joke" onclick="newPrompt('joke')" value="Tell me a joke!">
            <input type="button" class="prompt" id="joke2" onclick="newPrompt('wyr')" value="Would you rather">
            </form><br>
            <!-- <iframe name="content" class="iframe" id="iframe"></iframe><br><br> -->


        <!-- <footer>
               <p>
                ?? EARS
               </p> 
        </footer> -->

        <script>
            links();
            
            function setlinks(prompt) {
                const facebookBtn = document.getElementById("facebook");
                const twitterBtn = document.getElementById("twitter");
                const pinterestBtn = document.getElementById("pinterest");
                const linkedinBtn = document.getElementById("linkedin");
                const whatsappBtn = document.getElementById("whatsapp");
                
                const postImg = encodeURI("images/frog-body-with-mouth.png".src);
                let postUrl = encodeURI(document.location.href);
                let postTitle = encodeURI(prompt);
                
                facebookBtn.setAttribute(
                    "href",
                    `https://www.facebook.com/sharer.php?u=${postUrl}`
                );
                
                twitterBtn.setAttribute(
                    "href",
                    `https://twitter.com/share?url=${postUrl}&text=${postTitle}`
                );
                
                pinterestBtn.setAttribute(
                    "href",
                    `https://pinterest.com/pin/create/bookmarklet/?media=${postImg}&url=${postUrl}&description=${postTitle}`
                );
                
                linkedinBtn.setAttribute(
                    "href",
                    `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTitle}`
                );
                
                whatsappBtn.setAttribute(
                    "href",
                    `https://wa.me/?text=${postTitle} ${postUrl}`
                );
            }
        </script>
    </body>
 </html>