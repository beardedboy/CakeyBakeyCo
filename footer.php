        <footer class = "main_footer">
            <div class = "container">
                <div class = "row main_footer_row">
                    <div class = "col-5-12 main_footer_left_col">
                        <h3 class = "h2 main_footer_contact_title">Say hello</h3>
                        <p class = "pg main_footer_contact_paragraph">Feel free to send us a message and lets talk cake!</p>
                        <a href ="" class = "btn_flat">Contact Us</a>
                    </div><!-- end col-5-12 main_footer_left_col -->
                    <div class = "col-7-12 main_footer_right_col">
                        <?php if ( has_nav_menu( 'footer-one' ) ) {
                         wp_nav_menu( footerNav1() );
                    }?>
                    <?php if ( has_nav_menu( 'footer-two' ) ) {
                         wp_nav_menu( footerNav2() );
                    }?>
                    <?php if ( has_nav_menu( 'footer-three' ) ) {
                         wp_nav_menu( footerNav3() );
                    }?>
                    </div><!-- end col-7-12 main_footer_right_col-->
                </div><!-- end row -->
                <div class = "row main_footer_row-last">
                        <div class = "main_footer_copyright">
                            &#169; Cakey Bakey Co. 2014
                        </div><!-- end main_footer_copyright -->
                        <div class = "main_footer_paypal">
                            <span class = "main_footer_paypal_title"> Payments by </span>
                            <table class ="main_footer_paypal_logo" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td align="center">
                                    <a href="https://www.paypal.com/uk/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/uk/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes'); return false;">
                                        <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png" width="200" border="0" alt="PayPal Acceptance Mark">
                                    </a>
                                    </td>
                                </tr>
                            </table><!-- PayPal Logo -->
                        </div><!-- end main_footer_paypal -->
                </div>
            </div><!-- end container -->
        </footer><!-- end main_footer -->
        <?php wp_footer(); ?>

        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>-->
        <script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>
<script type="text/javascript">
(function(d){
    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
    p.type = 'text/javascript';
    p.async = true;
    p.src = '//assets.pinterest.com/js/pinit.js';
    f.parentNode.insertBefore(p, f);
}(document));
</script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>