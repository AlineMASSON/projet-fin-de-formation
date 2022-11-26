/* eslint-disable max-len */
// == Import
// npm

// locaux
import { Link } from 'react-router-dom';
import Header from '../Header';
import './legals.scss';

// == Composant
function Legals() {
  return (
    <div className="legals">
      <Header linkTo="/" />
      <h2 className="legals__title">Mentions Légales</h2>
      <h3 className="legals__subtitle first">1 - Édition du site</h3>
      <p>
        En vertu de l'<em>article 6 de la loi n° 2004-575 du 21 juin 2004</em> pour la confiance dans l'économie numérique, il est précisé aux utilisateurs du site internet <a href="http://localhost:8080">http://localhost:8080</a> l'identité des différents intervenants dans le cadre de sa réalisation et de son suivi:
      </p>
      <ul>
        <li><strong>Propriétaire du site :</strong> Equipe UpTrain de l'école O'Clock promo Hermès - Contact : UpTrain@gmail.com 0606060606 - Adresse : 100 Rue d'UpTrain 75000 Paris.</li>
        <li><strong>Identification de l'entreprise :</strong> SAS Equipe UpTrain de l'école O'Clock promo Hermès au capital social de 100000€ - SIREN : - RCS ou RM : - Adresse postale : 100 Rue d'UpTrain 75000 Paris</li>
        <li><strong>Directeur de la publication :</strong> UpTrain - Contact : 0606060606.</li>
        <li><strong>Hébergeur :</strong> AutreUpTrain UpTrain 0606060606</li>
        <li><strong>Délégué à la protection des données :</strong> UpTrain - UpTrain@gmail.com</li>
        <li><strong>Autres contributeurs :</strong> Aline, Nabila, Mohamed, Thibaud</li>
      </ul>
      <h3 className="legals__subtitle">2 - Propriété intellectuelle et contrefaçons.</h3>
      <p>
        Equipe UpTrain de l'école O'Clock promo Hermès est propriétaire des droits de propriété intellectuelle et détient les droits d’usage sur tous les éléments accessibles sur le site internet, notamment les textes, images, graphismes, logos, vidéos, architecture, icônes et sons.
        Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de <strong>Equipe UpTrain de l'école O'Clock promo Hermès.</strong>
        Toute exploitation non autorisée du site ou de l’un quelconque des éléments qu’il contient sera considérée comme constitutive d’une contrefaçon et poursuivie conformément aux dispositions des articles <em>L.335-2 et suivants du Code de Propriété Intellectuelle</em>.
      </p>
      <h3 className="legals__subtitle">3 - Limitations de responsabilité.</h3>
      <p>
        <strong>Equipe UpTrain de l'école O'Clock promo Hermès</strong> ne pourra être tenu pour responsable des dommages directs et indirects causés au matériel de l’utilisateur, lors de l’accès au site <a href="http://localhost:8080">http://localhost:8080</a>.
        <strong>Equipe UpTrain de l'école O'Clock promo Hermès</strong> décline toute responsabilité quant à l’utilisation qui pourrait être faite des informations et contenus présents sur <a href="http://localhost:8080">http://localhost:8080</a>.
        <strong>Equipe UpTrain de l'école O'Clock promo Hermès</strong> s’engage à sécuriser au mieux le site <a href="http://localhost:8080">http://localhost:8080</a>, cependant sa responsabilité ne pourra être mise en cause si des données indésirables sont importées et installées sur son site à son insu.
        Des espaces interactifs (espace contact ou commentaires) sont à la disposition des utilisateurs. Equipe UpTrain de l'école O'Clock promo Hermès se réserve le droit de supprimer, sans mise en demeure préalable, tout contenu déposé dans cet espace qui contreviendrait à la législation applicable en France, en particulier aux dispositions relatives à la protection des données.
        Le cas échéant, Equipe UpTrain de l'école O'Clock promo Hermès se réserve également la possibilité de mettre en cause la responsabilité civile et/ou pénale de l’utilisateur, notamment en cas de message à caractère raciste, injurieux, diffamant, ou pornographique, quel que soit le support utilisé (texte, photographie …).
      </p>
      <h3 className="legals__subtitle">4 - CNIL et gestion des données personnelles.</h3>
      <p>
        Conformément aux dispositions de <em>la loi 78-17 du 6 janvier 1978 modifiée</em>, l’utilisateur du site <a href="http://localhost:8080">http://localhost:8080</a> dispose d’un droit d’accès, de modification et de suppression des informations collectées. Pour exercer ce droit, envoyez un message à notre Délégué à la Protection des Données :<strong>UpTrain - UpTrain@gmail.com.</strong>
        Pour plus d'informations sur la façon dont nous traitons vos données (type de données, finalité, destinataire...), lisez notre <a href="http://localhost:8080/confidentialite">http://localhost:8080/confidentialite.</a>
      </p>
      <h3 className="legals__subtitle">5 - Liens hypertextes et cookies</h3>
      <p>
        Le site <a href="http://localhost:8080">http://localhost:8080</a> contient des liens hypertextes vers d’autres sites et dégage toute responsabilité à propos de ces liens externes ou des liens créés par d’autres sites vers <a href="http://localhost:8080">http://localhost:8080.</a> La navigation sur le site <a href="http://localhost:8080">http://localhost:8080</a> est susceptible de provoquer l’installation de cookie(s) sur l’ordinateur de l’utilisateur.
        Un "cookie" est un fichier de petite taille qui enregistre des informations relatives à la navigation d’un utilisateur sur un site. Les données ainsi obtenues permettent d'obtenir des mesures de fréquentation, par exemple.
        Vous avez la possibilité d’accepter ou de refuser les cookies en modifiant les paramètres de votre navigateur. Aucun cookie ne sera déposé sans votre consentement.
        Les cookies sont enregistrés pour une durée maximale de 1 mois.
        Pour plus d'informations sur la façon dont nous faisons usage des cookies, lisez notre <a href="http://localhost:8080/confidentialite">http://localhost:8080/confidentialite.</a>
      </p>
      <h3 className="legals__subtitle">6 - Droit applicable et attribution de juridiction.</h3>
      <p className="last">
        Tout litige en relation avec l’utilisation du site <a href="http://localhost:8080">http://localhost:8080</a> est soumis au droit français. En dehors des cas où la loi ne le permet pas, il est fait attribution exclusive de juridiction aux tribunaux compétents de <strong>Paris</strong>.
      </p>
      <Link className="link" to="/">Retour à l'accueil</Link>
    </div>
  );
}

// == Export
export default Legals;
