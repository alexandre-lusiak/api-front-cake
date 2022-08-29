## BASE DU PROJET COOKCAKE


TYPE PROJET : -E-Commerce (Commande de Gateaux)
// parti BACK 

USER : 
    propriété {
        id,lastName,firsName,mail,phone,role,password,address_id,register_at,billing_adress,comment_id
    }


Address : 
    propriété {
        id,country,city,postalCode,address_1,address_2
    }


CAKE : 
    propriété {
        id,name,ingredient,price,nbPerson,poids,picture
    }

categotyCake : 
    propriété {
        id,name,description
    }

Order : 
    propriété {
        user_id,cake_id,created_at,statut
    }

Comment : 
    propriété :{
        user_id,content,cake_id,created_at
    }

Invoice : 
    propriété :{
        user_id,cake_id,created_at
    }


parti Front : 

PAGE : HOME , CAKES ,CAKE, ,contactez-nous , UserPAge, AdminPage,CGU,CGI

FONCTIONNALITE : 

    USER : 
        Register/connexion
        reset password 
        modifier son profil
        voir Historiqye de commande
        commander (ajout panier)
        commenter
        contacter l'admin(mail);

    Admin : 
        ajouter/modifier/supprimé gateaux
        ajouter/modifier/supprimé categotyCake
        voir commande 
        commentaite (réponse/suppression)   