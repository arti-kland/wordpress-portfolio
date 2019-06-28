<?php
/**
 * Template Name: page contact
 */

$nb1 = rand(1, 9);
$nb2 = rand(1, 9);


if (isset($_POST['send'])):

    $valid = true;
    $message = array();

    // ----------- Vérification des champs ------------
    //teste le nom
    if (empty($_POST['ctc-nom'])) {
        $message['nom'] = "entrez votre nom";
        $valid = false;
    }
    //teste le mail
    if (empty($_POST['ctc-mail'])) {
        $message['mail'] = "entrez votre email";
        $valid = false;
    }
    if (!is_email($_POST['ctc-mail']) && !empty($_POST['ctc-mail'])) {
        $message['mail'] = "Entrez une adresse valide";
        $valid = false;
    }

    //teste le message
    if (empty($_POST['ctc-message'])) {
        $message['message'] = "entrez votre message";
        $valid = false;
    }
    //teste le captcha
    $captcha = $_POST['captcha'];
    if (empty($captcha)) {
        $message['captcha'] = "Vous n'aveez pas saisi le résultat anti-spam";
        $valid = false;
    } elseif (!is_numeric($captcha)) {
        $message['captcha'] = "Votre saisie anti-spam n'est pas numérique";
        $valid = false;
    } elseif ($captcha != base64_decode($_POST['check1']) + base64_decode($_POST['check2'])) {
        $message['captcha'] = "la saisie anti-spam ne correspond pas au résultat";
        $valid = false;
    }
    //---------- Ajoute l'enregistrement du message dans la table custom de la BDD
if ($valid == true):

    global $wpdb;
    $tablename = $wpdb -> prefix . "contacts";

    $ctc_data = array(
            'ctc_nom'           => $_POST['ctc-nom'],
            'ctc_mail'          => $_POST['ctc-mail'],
            'ctc_telephone'     => (strlen($_POST['ctc-telephone']) > 0 ? $_POST['ctc-telephone'] : ''),
            'ctc_message'       => $_POST['ctc-message'],
            'created_at'        => current_time('mysql', 0)
    );

    if($wpdb -> insert($tablename, $ctc_data)):
        if(session_id()):
            $_SESSION['contact-result'] = "Votre message est envoyé, nous vous répondrons prochainement";
        endif;
        wp_redirect(home_url());
    endif;
endif;

endif;

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-0">
            <h1>Nous contacter :</h1>
            <form id="lg-contact" action="<?php the_permalink(); ?>" method="post">
                <p>Utilisez ce formulaire pour nous contacter, nous vous répondrons dans les meilleurs delais</p>
                <!-- champs 1 -->
                <div class="form-group">
                    <!--- nom ---->
                    <label for="ctc-nom">Votre Nom</label>
                    <?php if (isset($message['nom'])) { ?>
                        <div class="text-white bg-danger px-3"><?php echo $message['nom']; ?></div>
                    <?php } ?>
                    <input type="text" class="form-control" id="ctc-nom" name="ctc-nom" size="50"
                           placeholder="Votre Nom..."
                           value="<?php echo (isset($_POST['ctc-nom'])) ? esc_attr($_POST['ctc-nom']) : ''; ?>"/>
                    <small class="text-danger"><b>* Requis</b></small>
                </div><!-- /form-group nom -->

                <!-- champs 2 -->
                <div class="form-group">
                    <!--- mail ---->
                    <label for="ctc-mail">Votre email</label>
                    <?php if (isset($message['mail'])) { ?>
                        <div class="text-white bg-danger px-3"><?php echo $message['mail']; ?></div>
                    <?php } ?>
                    <input type="text" class="form-control" id="ctc-mail" name="ctc-mail" size="50"
                           placeholder="Votre Mail..."
                           value="<?php echo (isset($_POST['ctc-mail'])) ? esc_attr($_POST['ctc-mail']) : ''; ?>"/>
                    <small class="text-danger"><b>* Requis</b></small>
                </div><!-- /form-group mail -->

                <div class="form-group">
                    <!--- telephone ---->
                    <label for="ctc-telephone">Votre telephone</label>
                    <input type="text" class="form-control" id="ctc-telephone" name="ctc-telephone" size="50"
                           placeholder="Votre téléphone..."
                           value="<?php echo (isset($_POST['ctc-telephone'])) ? esc_attr($_POST['ctc-telephone']) : ''; ?>"/>
                </div><!-- /form-group telephone -->

                <div class="form-group">
                    <!--- message ---->
                    <label for="ctc-message">Votre emessage</label>
                    <?php if (isset($message['message'])) { ?>
                        <div class="text-white bg-danger px-3"><?php echo $message['message']; ?></div>
                    <?php } ?>

                    <textarea class="form-control" id="ctc-message" name="ctc-message" cols="42" rows="10"
                              placeholder="Votre Message..."><?php echo (isset($_POST['ctc-message'])) ? esc_attr($_POST['ctc-message']) : ''; ?>
                    </textarea>
                    <small class="text-danger"><b>* Requis</b></small>
                </div><!-- /form-group message -->

                <!--- anti-spam ---->
                <div class="form-group">
                    <input type="hidden" name="check1" value="<?php echo base64_encode($nb1); ?>"/>
                    <input type="hidden" name="check2" value="<?php echo base64_encode($nb2); ?>"/>
                    <p> Anti-Spam, saisir le résultat de l'opération&nbsp; :
                        <span id="captcha">
                        <?php echo $nb1; ?>&nbsp; + &nbsp;<?php echo $nb2; ?>
                    </span>
                    </p>
                    <label for="captcha"> dans &nbsp;cette&nbsp;zone:&nbsp;</label>
                    <?php if (isset($message['captcha'])) { ?>
                        <div class="text-white bg-danger px-3"><?php echo $message['captcha']; ?></div>
                    <?php } ?>
                    <input type="text" id="captcha" name="captcha"/>
                    <small class="text-danger"><b> * Requis</b></small>
                </div>
                <!--- boutton ---->
                <div class="form-group">
                    <input type="submit" class="btn btn-success" id="send" name="send" value="Envoyer"/>
                </div>

            </form>
        </div><!-- /col-12 -->
        <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-0">
            <?php if (have_posts()):
                while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile;
            endif; ?>
        </div><!-- /col-12 -->

    </div> <!-- /row -->
</div> <!-- /container -->

<?php get_footer(); ?>
