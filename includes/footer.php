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
     
     
     <!--************************************the end of the new news section that is made of the two main secton ******-->



    </div><!-- end main -->

    </div><!-- end container-inner -->

</div><!-- end container -->

<div id="footer">
	<p>&copy; Eastern Michigan University's Graduate Engineering Management 2010-2024. Design by <a href="#">Mohammad Esmaeili</a></p>
</div><!-- end footer -->


</body>
</html>
