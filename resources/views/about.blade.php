@extends('layouts.app')
@section('title',"A propos")

@section('content')
        <!-- Who we are
    ============================================= -->
    <section class="section">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 d-flex">
              <div class="my-auto px-0 px-lg-5 mx-2">
                <h2 class="text-9">À propos de nous</h2>
                <p class="text-4">Nous savons que vous êtes très occupé à travailler. 
                Nous vous facilitons donc l'envoi d'argent à votre famille et à vos amis. 
                Nous ferons parvenir votre argent à ceux qui en ont besoin de manière pratique,
                 rapide, sécurisée et aux meilleurs taux de change possible 
                 pour que vous puissiez tirer le maximum de votre argent. </p>
                 <p class="text-3">Nous vous  facilitons l'envoi d'argent à votre famille et à
                  vos amis. En le faisant parvenir de manière pratique,
                   rapide et sécurisée aux meilleurs taux de change possible 
                   afin que vous puissiez en tirer le maximum.</p>
              </div>
            </div>
            <div class="col-lg-6 my-auto text-center"> <img class="img-fluid shadow-lg rounded-lg" src="images/thinking.jpg" alt=""> </div>
          </div>
        </div>
    </section>
      <!-- Who we are end -->
      
      <!-- Our Values
      ============================================= -->
      <section class="section bg-white">
        <div class="container">
          <div class="row no-gutters">
            <div class="col-lg-6 order-2 order-lg-1">
              <div class="row">
                <div class="col-6 col-lg-7 ml-auto mb-lg-n5"> <img class="img-fluid rounded-lg shadow-lg" src="images/pexels.jpg" alt="banner"> </div>
                <div class="col-6 col-lg-8 mt-lg-n5"> <img class="img-fluid rounded-lg shadow-lg" src="images/receptionists.jpg" alt="banner"> </div>
              </div>
            </div>
            <div class="col-lg-6 d-flex order-1 order-lg-2">
              <div class="my-auto px-0 px-lg-5">
                <h2 class="text-9 mb-4">Devenir un agent Lisocash</h2>
                <h4 class="text-4 font-weight-500">Comment le devenir?</h4>
                <p class="tex-3" >Rejoindre le réseau Lisocash offre plusieurs avantages
                    Augmentation de trafic et revenus additionnels
                    Attirer une nouvelle clientèle
                    Offrir un service complémentaire
                    Générer du revenu additionnel
                    Une marque forte et international
                    Rejoindre une entreprise  de transferts de fonds
                    Appartenir à un réseau de plusieurs agences
                    Une présence dans plusieurs pays et territoires
                    Soutien continu.
                </p>
                {{-- <h4 class="text-4 font-weight-500 mb-2">Notre vision</h4> --}}
                <p class="tex-3" >Formation, matériel pour point de vente et logiciel
                    Technologie de pointe combinée à un centre d’appel 24/24
                    Soutien marketing pour générer du trafic et des ventes
                    Conformité.
                </p>
                {{-- <h4 class="text-4 font-weight-500 mb-2">Notre objectif</h4> --}}
                <p class="tex-3" >Un fort accent mis sur la prévention du blanchiment de fonds et de la fraudee
                  Une aide sur les obligations de rapports et de la tenue des comptes
                  Une qualité assurée pour les clients à tout moments.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Our Values end -->
      
             <!-- Who we are
    ============================================= -->
    <section class="section">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 d-flex">
              <div class="my-auto px-0 px-lg-5 mx-2">
                <h2 class="text-9">Comment ça marche ?</h2>
                <p class="text-4">Avec Baxe money, finie la galère pour envoyer 
                de l'argent à vos amis. Un simple numéro de téléphone vous suffit. 
                Votre bénéficiaire est informé par SMS et reçoit directement 
                l'argent sur son compte bancaire, facile n'est-ce pas !.</p>

                <p class="text-4">Vous pouvez également utiliser Baxe pour :
                      picto qui présente le paiement mobile en magasin, payer en magasin.
                      Je paye avec mon mobile, chez tous les commerçants qui acceptent
                       le paiement qr code, même au-delà de.
                </p>
              </div>
            </div>
            <div class="col-lg-6 my-auto text-center"> <img class="img-fluid shadow-lg rounded-lg" src="images/who-we-are.jpg" alt=""> </div>
          </div>
        </div>
    </section>
    
      
      <!-- Testimonial
      ============================================= -->
      <section class="section">
        <div class="container">
          <h2 class="text-9 text-center">Ce que disent nos abonnés</h2>
          <p class="text-4 text-center mb-4">Nos abonnés aiment parler du bien que Lisocash leur apporte</p>
          <div class="owl-carousel owl-theme" data-autoplay="true" data-nav="true" data-loop="true" data-margin="30" data-slideby="2" data-stagepadding="5" data-items-xs="1" data-items-sm="1" data-items-md="2" data-items-lg="2">
            <div class="item">
              <div class="testimonial rounded text-center p-4">
                <p class="text-4">“Easy to use, reasonably priced simply dummy text of the printing and typesetting industry. Quidam lisque persius interesset his et, in quot quidam possim iriure.”</p>
                <strong class="d-block font-weight-500">Jay Shah</strong> <span class="text-muted">Founder at Icomatic Pvt Ltd</span> </div>
            </div>
            <div class="item">
              <div class="testimonial rounded text-center p-4">
                <p class="text-4">“I am happy Working with printing and typesetting industry. Quidam lisque persius interesset his et, in quot quidam persequeris essent possim iriure.”</p>
                <strong class="d-block font-weight-500">Patrick Cary</strong> <span class="text-muted">Freelancer from USA</span> </div>
            </div>
            <div class="item mh-100">
              <div class="testimonial rounded text-center p-4">
                <p class="text-4">“Fast easy to use transfers to a different currency. Much better value that the banks.”</p>
                <strong class="d-block font-weight-500">De Mortel</strong> <span class="text-muted">Online Retail</span> </div>
            </div>
            <div class="item">
              <div class="testimonial rounded text-center p-4">
                <p class="text-4">“I have used them twice now. Good rates, very efficient service and it denies high street banks an undeserved windfall. Excellent.”</p>
                <strong class="d-block font-weight-500">Chris Tom</strong> <span class="text-muted">User from UK</span> </div>
            </div>
            <div class="item">
              <div class="testimonial rounded text-center p-4">
                <p class="text-4">“It's a real good idea to manage your money by payyed. The rates are fair and you can carry out the transactions without worrying!”</p>
                <strong class="d-block font-weight-500">Mauri Lindberg</strong> <span class="text-muted">Freelancer from Australia</span> </div>
            </div>
            <div class="item">
              <div class="testimonial rounded text-center p-4">
                <p class="text-4">“Only trying it out since a few days. But up to now excellent. Seems to work flawlessly. I'm only using it for sending money to friends at the moment.”</p>
                <strong class="d-block font-weight-500">Dennis Jacques</strong> <span class="text-muted">User from USA</span> </div>
            </div>
          </div>
          {{-- <div class="text-center mt-4"><a href="#" class="btn-link text-4">See more people review<i class="fas fa-chevron-right text-2 ml-2"></i></a></div> --}}
        </div>
      </section>
      <!-- Testimonial end -->
      
       <!-- Our Values
      ============================================= -->
      <section class="section bg-white">
        <div class="container">
          <div class="row no-gutters">
            <div class="col-lg-6 order-2 order-lg-1">
              <div class="row">
                <div class="col-6 col-lg-7 ml-auto mb-lg-n5"> <img class="img-fluid rounded-lg shadow-lg" src="images/our-values-vision.jpg" alt="banner"> </div>
                <div class="col-6 col-lg-8 mt-lg-n5"> <img class="img-fluid rounded-lg shadow-lg" src="images/our-values-mission.jpg" alt="banner"> </div>
              </div>
            </div>
            <div class="col-lg-6 d-flex order-1 order-lg-2">
              <div class="my-auto px-0 px-lg-5">
                <h2 class="text-9 mb-4">CE QUE NOUS APPRÉCIONS</h2>
                {{-- <h4 class="text-4 font-weight-500">Comment le devenir?</h4> --}}
                <p class="tex-3" >Depuis nos débuts, nous avons mis la technologie au 
                    service de la connexion des personnes. Au fur et à mesure que la technologie a
                 progressé, nous aussi, 
                    mais toujours en nous concentrant sur la
                     connexion des personnes avec les lieux et les êtres chers qui comptent le plus pour elles, dans les bons comme dans les mauvais moments.
                </p>
       
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Our Values end -->

      <!-- JOIN US
      ============================================= -->
      <section class="section bg-primary py-5">
        <div class="container text-center">
          <div class="row">
            <div class="col-sm-6 col-md-3">
              <div class="featured-box text-center">
                <div class="featured-box-icon text-light mb-2"> <i class="fas fa-globe"></i> </div>
                <h4 class="text-12 text-white mb-0">180+</h4>
                <p class="text-4 text-white mb-0">Pays</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="featured-box text-center">
                <div class="featured-box-icon text-light mb-2"> <i class="fas fa-dollar-sign"></i> </div>
                <h4 class="text-12 text-white mb-0">120</h4>
                <p class="text-4 text-white mb-0">Devises</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3 mt-4 mt-md-0">
              <div class="featured-box text-center">
                <div class="featured-box-icon text-light mb-2"> <i class="fas fa-users"></i> </div>
                <h4 class="text-12 text-white mb-0">5M</h4>
                <p class="text-4 text-white mb-0">Utilisateurs</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-3 mt-4 mt-md-0">
              <div class="featured-box text-center">
                <div class="featured-box-icon text-light mb-2"> <i class="far fa-life-ring"></i> </div>
                <h4 class="text-12 text-white mb-0">24X7</h4>
                <p class="text-4 text-white mb-0">Support client</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- JOIN US end -->
@endsection