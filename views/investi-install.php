<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<style>
.front-page-logo {
    width: 110.6px;
    height: 50px;
}

.header {
    margin: 15px 0;
    padding: 8px;
}

.investi-dark-blue {
    background-color: #01133e;
}

.fields {
    margin: 15px 0;
}

.hidden {
    display: none;
}

#investi-apikey-error {
    color: red;
    background-color: white;
    padding: 20px;
}

.help {
    margin-top: 20px;
    background: #fff;
    padding: 10px;
}

pre.wp-block-code {
    border: 1px solid gray;
    background-color: #F5F7F9;
    padding: 10px 2px;
    margin-bottom: 40px;
}

.settings-container {
    display: flex;
    justify-content: space-between;
    width:50%;
    
}
.circle {
    border-radius: 50%;
    color:#fff;
    border: 1px solid #fff;
    background-color: lightblue;
    padding: 1px 5px;
    cursor: pointer;
}

</style>

<div>

    <div class="header investi-dark-blue">
        <img class="front-page-logo" src="<?php echo esc_html(plugins_url( 'logo.svg' , __FILE__ )); ?>" />
        
    </div>

    <form action="<?php echo esc_html(sanitize_text_field($_SERVER['REQUEST_URI'])); ?>" method="post">

    <?php wp_nonce_field( 'investi-admin-save' ); ?>

        <div class="settings-container">
            <div>
                <div class="fields">
                    <span>API Key</span>
                    <input id="investi-apikey" type="text" name="investi-apikey" size="60"
                        value="<?php echo esc_html(investi_getApiKey()); ?>" />
                </div>

                <div id="investi-apikey-error" class="hidden fields">
                    Invalid API Key. Please check
                </div>

                <div id="investi-non-editable-fields" class="hidden fields">
                    <span>Ticker</span>
                    <input type="text" id="investi-ticker" disabled>
                    <span> </span>
                </div>

            </div>


            <div class="advanced-settings">
            <h2>Advanced</h2>    
            
            
                <input type="checkbox" name="investi-do-not-add-css" value="1"
                <?php if (get_option('investi-do-not-add-css') == 1) { echo esc_html("checked='checked'"); } ?>
                /><span>Do not use Investi CSS <span class="circle" title="Only check this if you are implementing all your own CSS for the widgets">?</span></span>

                
            </div>



        </div>


        <input type="submit" value="Save Changes" class="button-primary" />
    </form>

    <div class="help">

        <p><b>How do I get an API Key for a specific stock?</b></p>
        <p>Please email us at contact@investi.com.au and we will provide you with one. (1 month free trial)</p>

    </div>

    <div class="help">

        <p><b>I've got to build an investor dashboard and I've only got 5 minutes, how do i do it?</b></p>
        <p>Please see our sample <a href="https://web.investi.com.au/investor-dashboard/" target="__blank"> Investor
                Dashboard</a> page</p>

    </div>

    <div class="help">

        <p><b>What is the complete list of shortcodes and their arguments?</b></p>
        <p>Please see our  <a href="https://web.investi.com.au/shortcodes/" target="__blank">shortcodes </a> page</p>

    </div>
    

</div>

<script>
(async () => {
    const apiKey = document.getElementById("investi-apikey").value;
    if (apiKey) {
        const response = await fetch(`https://api.investi.com.au/api/marketdata?apiKey=${apiKey}`);
        if (response.status == 200) {

            const marketData = await response.json();

            jQuery("#investi-ticker").val(`${marketData.ticker}:${marketData.exchange}`);

            jQuery("#investi-non-editable-fields").show();
        } else {
            console.log('response', response)
            jQuery("#investi-apikey-error").show();
        }
    }

})();
</script>