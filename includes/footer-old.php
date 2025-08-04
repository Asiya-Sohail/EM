        </div><!-- end content -->


        <div class="sidebar">
        
        <div class="sidebar-inner">
        <script type="text/javascript">
           window.onload = imgSlids;
           var myPix = new Array("style/images/flash1.jpg","style/images/flash2.jpg","style/images/flash3.jpg");
           var thisImg = 0;

           function imgSlids(){
           if (thisImg == 0){
              thisImg = myPix.length;
              }
              thisImg--;
              document.getElementById("slids").src = myPix[thisImg];
              t=setTimeout("imgSlids()",4000);
              return false;
              }
           </script>
            <img  width= "100%" id ="slids" src="style/images/flash1.jpg"/>
        </div>



               <div class="sidebar-inner">
        <h4>Current jobs</h4>

      <script type="text/javascript">
              $(document).ready(function () {
              $('#ticker1').rssfeed('http://rss.indeed.com/rss?q=engineering+management&l=Ypsilanti%2C+MI').ajaxStop(function() {
		          $('#ticker1 div.rssBody').vTicker({ showItems: 2});
	          });
           });
       </script>
        
        <div id="ticker1"></div>

        </div>

        <div class="sidebar-inner">
        <h4>Current Students Presentions</h4>

<div><script language="javascript" type="text/javascript"> var _UserId="DhOuRABcag4%3d"; var _UserName = "msohailahmed"; var _rows=2; var _cols=2; var _backcolor="#F8F8F8"; var _heading="default"; var _layout="true"; var _ptitle="true";var _mystuff="0";var _stuffType=1;var jsSiteUrl = 'http://www.authorstream.com/';</script><script language="javascript" type="text/javascript" src="http://www.authorstream.com/Javascript/PresentationWidget.js"></script></div>
        
        <div id="ticker1"></div>

        </div>




     <!--
         <div class="sidebar-inner">
         <h4>Latest News</h4>
				<div class="news-item">
					<span class="date">01.05.2011</span>
					<a href="#">The first phase</a> of the website will be up and running by the begining of the Winter semester.
                </div>
     -->
                
			<!--	<div class="news-item">
					<span class="date">19.10.2010</span>
					<a href="#">Consectetuer adipiscing elit</a> Proin vitae lorem vel tortor vestibulum fringilla vel ut turpis. Phasellus pulvinar hendrerit ligula
				</div>

				<div class="news-item">
					<span class="date">18.08.2010</span>
					<a href="#">Praesent vestibulum e</a> Sed sagittis mauris sed mi scelerisque pellentesque. Praesent quis arcu mauris!
                </div>     -->
         </div>
       </div><!-- end sidebar -->

     <div class="clear"></div>



     <!--************************************the begining of the new news section that is made of the two main secton ******-->
     <!-- <table>

           <tr> <th width=40%> This Month news  </th> <th width=40%> This semester news</th></tr>
            <tr>
                <td>
                            monthly news1<br/><br/><br/>monthly news2

                <td>
                            yearly news2 <br/><br/><br/>yearly news2
                </td>
            </tr>



      </table>  -->
     
     
     <!--************************************the end of the new news section that is made of the two main sections ******-->



    </div><!-- end main -->

    </div><!-- end container-inner -->

</div><!-- end container -->



<div id="footer">
	<p>&copy; Eastern Michigan University Online Graduate Engineering Management 2010-2023. Design by <a href="#">Mohammad Esmaeili</a></p>
</div><!-- end footer -->
<?php 
require_once("includes/connection.php");
mysqli_close($connection);?>




<table>
<tr>
<td>

<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"

WIDTH="300"

HEIGHT="100"

CODEBASE="http://active.macromedia.com/flash5/cabs/swflash.cab#version=5,0,0,0">

<PARAM NAME="MOVIE" VALUE="general/Training.swf">

<EMBED SRC="general/Training.swf"

WIDTH="300"

HEIGHT="100"

PLAY="true"

LOOP="true"

QUALITY="high"

scale="noborder"

PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">

</EMBED>

</OBJECT>

<!--
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/
cabs/flash/swflash.cab#version=6,0,40,0"
 height="60"  id="mymoviename">
<param name="movie"
value="general/Michael.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="general/Michael.swf" quality="high" bgcolor="#ffffff"
 height="60"
name="mymoviename" align="" type="application/x-shockwave-flash"
pluginspage="http://www.macromedia.com/go/getflashplayer">
</embed>
</object>
-->

</td>

<td>


<img src="style/images/EMUEM-logo1.jpg" />

</td>
<td>

<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"

WIDTH="300"

HEIGHT="100"

CODEBASE="http://active.macromedia.com/flash5/cabs/swflash.cab#version=5,0,0,0">

<PARAM NAME="MOVIE" VALUE="general/Student2UP2.swf">

<EMBED SRC="general/Student2UP2.swf"

WIDTH="300"

HEIGHT="100"

PLAY="true"

LOOP="true"

QUALITY="high"

scale="noborder"

PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">

</EMBED>

</OBJECT>




<!--

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/
cabs/flash/swflash.cab#version=6,0,40,0"
 height="60"  id="mymoviename">
<param name="movie"
value="general/Nigel.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="general/Nigel.swf" quality="high" bgcolor="#ffffff"
 height="60"
name="mymoviename" align="" type="application/x-shockwave-flash"
pluginspage="http://www.macromedia.com/go/getflashplayer">
</embed>
</object>
-->


</td>
</tr>

</table>



</body>
</html>
