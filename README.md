# WordifyNumber

WordifyNumber est une bibliothèque PHP permettant de convertir des nombres en mots, en prenant en charge différentes langues et formats.

## But du Projet

Ce projet a été initialement conçu à des fins personnelles dans le contexte de la création d'un ERP (Enterprise Resource Planning) destiné aux entreprises, avec un accent particulier sur la fonction de facturation automatisée. L'une des fonctionnalités clés de cette automatisation est la conversion des montants numériques en lettres pour une présentation plus conviviale sur les documents de facturation.

WordifyNumber a été créé dans l'optique de fournir une solution autonome et légère pour cette tâche spécifique, sans dépendre d'autres bibliothèques externes. L'objectif est de permettre une intégration facile dans le projet ERP, offrant ainsi une fonction de conversion de nombres en lettres sans avoir à s'appuyer sur des solutions tierces. Cela garantit une plus grande maîtrise et personnalisation de la logique de conversion, répondant ainsi précisément aux besoins du système de facturation automatisée.

Wordify s'inspire d'autres projets plus complets du même domaine, tels que kwn/number-to-words.

## Installation

Pour utiliser cette bibliothèque dans votre projet, vous devez l'installer via Composer. Ajoutez ceci à votre fichier `composer.json` :

```bash
composer require rostand-dev/wordify-number
```

## Utilisation
  Il existe deux types de transformation des nombres en mots : les nombres et les devises. Afin d'utiliser un transformateur approprié pour une langue spécifique, créez une instance de la classe NumberToWords et appelez une méthode qui crée une nouvelle instance du transformateur souhaité.
  Le language par défaut est le français : fr ; et la devise le XOF.
  ### Création de l'instance
```php
$wordify = new WordifyNumber();
```
  ### Number Transformer 
```php
echo $wordify::transformNumber(12345, 'fr'); // Affiche "douze mille trois cent quarante-cinq"
```  
  ### Currency Transformer 
```php
echo $wordify::transformNumber(12345, 'XOF', 'fr); // Affiche "douze mille trois cent quarante-cinq"
```  
## Contribuer
  Liste des contributeurs : [contributeurs](https://github.com/roslove44/wordifyNumber/graphs/contributors)
Si vous souhaitez contribuer à ce projet, veuillez suivre ces étapes :

1. Forkez le projet
2. Créez une nouvelle branche (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commitez vos modifications (`git commit -am 'Ajout d'une nouvelle fonctionnalité'`)
4. Pushez la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrez une demande d'extraction sur GitHub

## Licence

Ce projet est sous licence [MIT](LICENSE).
