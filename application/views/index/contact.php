<div class="row">
    <div class="span12">
        <h1>Contact</h1>
        <?php
            $this->load->library('form_validation');
            
            $errors = validation_errors();
            if ($errors != "") {
        ?>
        <div class="alert alert-error">
            <?php echo $errors; ?>
        </div>
        <?php
        
            }

            if ($success == false) {
        ?>
        <p>Pour toute question ou remarque, n'hésitez pas à nous écrire par le biais du formulaire ci-dessous.</p>
        <br />
        <?

                echo form_open(current_url());

        ?>

        <table class='contact-form'>
        <?php
				echo "<tr>
                        <td>" . form_label('Surnom: ', 'nickname') . "</td>
                        <td>" . form_input('nickname', set_value('nickname')) . "</td>
                        </tr>";
						
                echo "<tr>
                        <td>" . form_label('Nom: ', 'firstname') . "</td>
                        <td>" . form_input('firstname', set_value('firstname')) . "</td>
                        </tr>";
                
                echo "<tr>
                        <td>" . form_label('Prénom: ', 'lastname') . "</td>
                        <td>" . form_input('lastname', set_value('lastname')) . "</td>
                        </tr>";

                echo "<tr>
                        <td>" . form_label('E-mail*: ', 'email'). "</td>
                        <td>" . form_input('email', set_value('email')) . "</td>
                        </tr>";
                
                echo "<tr>
                        <td>" . form_label('Confirmation de l\'E-mail*: ', 'email2'). "</td>
                        <td>" . form_input('email2', set_value('email2')) . "</td>
                        </tr>";

                $attributes = Array("name" => "message", "class" => "span5", "value" => set_value("message"), "rows" => "8");
                echo "<tr>
                        <td>".form_label('Message*: ', 'message'). "</td>
                        <td>" . form_textarea($attributes) . "<br /><p><small>Les champs marqués d'une astérisque sont obligatoires.</small></p></td>
                        </tr>";

                $attributes = Array("class" => "btn btn-primary", "value" => "Envoyer");
                echo "<tr>
                        <td></td>
                        <td>".form_submit($attributes) . "</td>
                        </tr>";

        ?>
        </table>

        <?
                echo form_close();
                echo "<br />";
            }else {
        ?>
        
        <br />
        <div class="alert alert-success"><p><span class="label label-success">Merci</span> Votre message a été envoyé avec succès.</p></div>
        
        <?php
            }
        ?>
    </div>
</div>