<!DOCTYPE html>

<?php require 'test.php' ?>

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta keyword="Virtual Pet, Frog, Would You Rather, Game">
        <title>Would You Rather | Virtual Frog</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="style2.css">
        <link rel="icon" href="images/icon.png" type="image/png">
        <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
        <script>
            
            /*********/
            
            const API_URL = "https://api.aakhilv.me/fun/wyr";
            const EDGECASE_1 = "Would you have an Alien friend or a Superhero friend?";
            const EDGECASE_2 = "If you had to give up one thing for the rest of your life, would it be brushing your hair or brushing your teeth?";
            const EDGECASE_3 = "Would you feel worse if no one showed up to your wedding or to your funeral?";
            var prompt;
            var option1;
            var option2;
            var ready = false;
            
            <?php 
            
            if(isset($_POST['prompt'])) {
              echo "ready = true; 
                    $('#op1').hide(); 
                    $('#op2').hide(); 
                    var donePrint = false;
                    froggyTalk('{$message}');"; 
            }
            
            ?>
      
            async function getPrompt()
            {
              const response = await fetch(API_URL);
              prompt = await response.json();
              return prompt;
            }
            
            function printPrompt(q)
            {
              document.getElementById("prompt").value = q;
              
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
          
              
              froggyTalk(q);
              
            }
            
            function froggyTalk(q)
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
                            donePrint = true;
                          }
                      }, 
                  i*textFrequency
                
                )
          
              }
              
            }
            
            function bubbleHover()
            {
              if (ready) {
                this.style.color="rgba(0, 0, 0, 0.2)";
                button = document.getElementById("next-prompt");
                button.style.visibility = "visible";
                button.style.opacity = 1;
              } else {
                this.style.color="black";
              }
            }
            
            function bubbleOut()
            {
              this.style.color="black";

              button = document.getElementById("next-prompt");
              button.style.visibility = "hidden";
              button.style.opacity = 0;
            }
            
            function eventListener()
            {
              
              if (!ready) {
                window.setTimeout(eventListener, 100);
              } else {
                
                bubble = document.getElementById("speech-bubble");
                bubble.addEventListener('mouseout', bubbleOut);
                
                button1 = document.getElementById("op1");
                button2 = document.getElementById("op2");
                
                button1.style.display = "inline-block";
                button2.style.display = "inline-block";
                
                button1.addEventListener("mouseover", highlightOption);
                button2.addEventListener("mouseover", highlightOption);
                button1.addEventListener("mouseout", unhighlightOption);
                button2.addEventListener("mouseout", unhighlightOption);
              }
              
          
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
         	
            window.onload = function(){
            
              if (ready == false) {
                newPrompt();
              } else {
                document.getElementById("next-prompt").value = "Next Prompt!";
                finalButton();
              }
              
            }
            
            function finalButton()
            {
              
              if (!donePrint) {
                window.setTimeout(finalButton, 100);
              } else {
                var bubble = document.getElementById("speech-bubble");
                bubble.addEventListener('mouseover', bubbleHover);
                bubble.addEventListener('mouseout', bubbleOut);
              }
              
            }
            
            function newPrompt() 
            {
              $("#op1").hide();
              $("#op2").hide();
              document.getElementById("next-prompt").value = "Different Prompt";
              ready = false;
              
              button = document.getElementById("next-prompt");
              button.style.visibility = "hidden";
              button.style.opacity = 0;
              
              var bubble = document.getElementById("speech-bubble");
              bubble.addEventListener('mouseover', bubbleHover);
              bubble.style.color = "black";
              
              getPrompt()
                .then(prompt => printPrompt(prompt))
                .then(eventListener)
                .catch(error => console.log("Caught exception: " + error));
            }
            
            /*********/
    
        </script>
    </head>



    <body>
        <ul>
            <li><a href="contact.html">Contact Us</a></li>
        </ul>
        
     <form action="" method="post">
        <input type="hidden" name="prompt" id="prompt">
        <!-- Display the question -->
        <div class="prompt-wrapper">
          <input class="prompt" id="op1" type="submit" name="option1" value="Option 1">
          <div class="prompt" id="speech-bubble"><div id="pwrap"><input class="prompt" id="next-prompt" type="button" name="diffprompt" value="Different Prompt" onclick="newPrompt()"></div><span id="shown">Would you rather...</span><span id="hidden">her asdfasdf asdf</span></div>
          <input class="prompt" id="op2" type="submit" name="option2" value="Option 2">
        </div>
        <a class="container" title="Frog Cartoon Picture from https://clipartmag.com/frog-cartoon-picture">
            <img src="images/frog-body.png" id="frog-body" /></a>
    
          </form><br>







        <footer>
               <p>
                © EARS
               </p> 
        </footer>


    </body>
 </html>