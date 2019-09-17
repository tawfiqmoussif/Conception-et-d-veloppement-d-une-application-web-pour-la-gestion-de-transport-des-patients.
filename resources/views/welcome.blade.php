@extends('layouts.auth')

@section('content')

<div class="super_container">

	<!-- Menu -->

	<div class="menu trans_500">
		<div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
			<div class="menu_close_container"><div class="menu_close"></div></div>
			<form action="#" class="menu_search_form">
				<input type="text" class="menu_search_input" placeholder="Search" required="required">
				<button class="menu_search_button"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
			<ul>
			<li ><img src="/health/images/Logo_CHU-final.png" alt="" style="width: 35%;margin-left: -90px;"></li>
				<li ><a href="#nous" style="margin-left: -800%;" >À propos</a></li>
				<li ><a href="#service" style="margin-left: -700%;">Services</a></li>
				<li ><a href="#contact" style="margin-left: -720%;">Contact</a></li>
			</ul>
		</div>
		<div class="menu_social">
			<ul>
				<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>
	
	<!-- Home -->

	<div class="home">
	
		<div class="background_image" style="background-image:url(/health/images/h2-ConvertImage.jpg)"></div>
		
		<!-- Header -->

		<header class="header" id="header">
			<div>
				
				<div class="header_nav" id="header_nav_pin">
					<div class="header_nav_inner">
						<div class="header_nav_container" style="background: #343a40;">
							<div class="container">
								<div class="row">
									<div class="col">
										<div class="header_nav_content d-flex flex-row align-items-center justify-content-start">
											<nav class="main_nav">
												<ul class="d-flex flex-row align-items-center justify-content-start">
												<li ><img src="/health/images/Logo_CHU-final.png" alt="" style="width: 35%;margin-left: -90px;"></li>
													<li><a href="#nous" style="margin-left: -800%;">À propos</a></li>
													<li><a href="#service" style="margin-left: -700%;">Services</a></li>
													<li><a href="#contact" style="margin-left: -720%;">Contact</a></li>											
												</ul>
                                            </nav>
                                            @guest
											<div class="ml-auto d-flex flex-row align-items-center main_nav">
													<button type="button" class="btn btn-outline-light font-weight-bold mr-2" data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">Login</button>
													<button type="button" class="btn btn-outline-warning font-weight-bold" data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Register</button>
                                            </div>
                                            @else
                                            <div class="ml-auto d-flex flex-row align-items-center main_nav">
												
					
														<a class="dropdown-item" href="{{ route('logout') }}"
														   onclick="event.preventDefault();
																		 document.getElementById('logout-form').submit();">
															{{ __('Logout') }}
														</a>
					
														<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
															@csrf
														</form>
												
										    </div>
                                            @endguest
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</header>

		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content">
							<div class="home_title" style="color: #343a40">CENTRE HOSPITALIER UNIVERSITAIRE HASSAN II</div>
							<div class="home_text"  style="color: #343a40">Un établissement de référence au service de la Santé</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- FAQ & News -->

	<div class="stuff" style="    background: #f5f5f5;">
		<div class="container">
		<div class="row">
				<div class="col text-center">
					<a name="nous"><div class="section_title"  >À propos</div></a>
					<br><br><br><br><br>
				</div>
			</div>
			<div class="row">

				<!-- FAQ -->
				<div class="col-lg-7">
					<div class="faq">
						<div class="faq_title">Le CHU Hassan II de Fès</div>
						<div class="elements_accordions">
							<div class="accordions">

								<div class="accordion_container" >
									<div class="accordion d-flex flex-row align-items-center active"><div>Meilleur centre hospitalier maghrébin et 10ème au niveau africain.</div></div>
									<div class="accordion_panel">
										<div>
											<p>Le Centre hospitalier universitaire (CHU) Hassan II de Fès a été choisi meilleur centre hospitalier maghrébin et 10ème au niveau africain par le site web spécialisé "Webometrics Hospitals", initié par le groupe de recherche espagnol indépendant "Cybermetrics Lab ».</p>
										</div>
									</div>
								</div>

								<div class="accordion_container">
									<div class="accordion d-flex flex-row align-items-center"><div>Occupe la 19-ème place au niveau arabe.</div></div>
									<div class="accordion_panel">
										<div>
											<p>Au niveau arabe, le CHU Hassan Il de Fès a occupé la 19-ème place, derrière des hôpitaux saoudiens, dont l'hôpital et centre de recherche spécialisé Roi Faiçal, qui trône au classement arabe, et émiratis notamment, mais devançant avec des écarts fort significatifs plusieurs cliniques et hôpitaux d'Egypte, du Maroc et de l’Algérie.</p>
										</div>
									</div>
								</div>

								<div class="accordion_container">
									<div class="accordion d-flex flex-row align-items-center"><div>Le CHU Hassan II de Fès en chiffres.</div></div>
									<div class="accordion_panel">
										<div>
											
											<p>
											<div>880 lits répartis dans 42 services </div>
											<ul style="margin: 20px;">
												<li>- 430 lits pour les spécialités chirurgicales</li>
												<li>- 350 lits pour les spécialités médicales</li>
												<li>- 65 lits pour la réanimation</li>
												<li>- 35 places pour les urgences et le SAMU</li>
											</ul>
											<div>28 salles opératoires  </div>
											<ul style="margin: 20px;">
												<li>- 2 salles opératoires multimédias équipées de télémédecine (liaison par FO avec salle de conférence au niveau de la faculté de médecine)</li>
												<li>- 3 salles opératoires pour les urgences</li>
												<li>- 14 salles opératoires pour les différentes spécialités (traumatologie CCV, NCH, VX, greffe, traumato viscérale, thoracique, ORL, URO…)</li>
											</ul>
											<ul>
											<div>Surface couverte : 78 102 m2 .</div>
											</ul>
											<ul>
											<div>surface totale : 12 ha.</div>
											</ul><ul>
											<div>Coût global : 1, 200 milliard de DH.</div>
											</ul>
										</p>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<!-- Latest News -->
				<div class="col-lg-5">
					<div class="news">
						<div class="news_title">Dernières nouvelles</div>						
						<div class="news_container">

							<!-- Latest News Post -->
							<div class="latest d-flex flex-row align-items-start justify-content-start">
								<div><div class="latest_image"><img src="/health/images/latest_1.jpg" alt=""></div></div>
								<div class="latest_content">
									<div class="latest_title"><a href="#nous">Avis concernant l’EAP pour l’accès au grade d’infirmier auxiliaire grade Principal – session Du 12/09/2019</a></div>
									
									
								</div>
							</div>

							<!-- Latest News Post -->
							<div class="latest d-flex flex-row align-items-start justify-content-start">
								<div><div class="latest_image"><img src="/health/images/latest_2.jpg" alt=""></div></div>
								<div class="latest_content">
									<div class="latest_title"><a href="#nous">Avis concernant l’EAP pour l’accès au grade de technicien de 3ème grade – session Du 12/09/2019</a></div>
									
									
								</div>
							</div>

							<!-- Latest News Post -->
							<div class="latest d-flex flex-row align-items-start justify-content-start">
								<div><div class="latest_image"><img src="/health/images/latest_3.jpg" alt=""></div></div>
								<div class="latest_content">
									<div class="latest_title"><a href="#nous">Calendrier prévisionnel des EAP du personnel relevant du CHU Hassan II au titre de l’année 2019</a></div>
									
									
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	
	

	<!-- Departments -->

	<div class="departments">
		<div class="container">
			<div class="row">
				<div class="col text-center">
				<a name="service"><div class="section_title"   >Services</div></a>
					
				</div>
			</div>
			<div class="row dept_row">
				<div class="col">
					<div class="dept_slider_container_outer">
						<div class="dept_slider_container">

							<!-- Slider -->
							<div class="owl-carousel owl-theme dept_slider">
								
								<!-- Slide -->
								<div class="owl-item dept_item">
									<div class="dept_image"><img src="/health/images/dept_1.jpg" alt=""></div>
									<div class="dept_content">
										<div class="dept_title">Néonatologie</div>										
									</div>
								</div>

								<!-- Slide -->
								<div class="owl-item dept_item">
									<div class="dept_image"><img src="/health/images/dept_2.jpg" alt=""></div>
									<div class="dept_content">
										<div class="dept_title">Dentisterie</div>
									</div>
								</div>

								<!-- Slide -->
								<div class="owl-item dept_item">
									<div class="dept_image"><img src="/health/images/dept_3.jpg" alt=""></div>
									<div class="dept_content">
										<div class="dept_title">Orthopédie</div>
									</div>
								</div>

								<!-- Slide -->
								<div class="owl-item dept_item">
									<div class="dept_image"><img src="/health/images/dept_4.jpg" alt=""></div>
									<div class="dept_content">
										<div class="dept_title">Laboratoire</div>
									</div>
								</div>

							</div>
							
						</div>

						<!-- Dept Slider Nav -->
						<div class="dept_slider_nav"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>

					</div>
						
				</div>
			</div>
		</div>
	</div>
	
	
	



	<!-- Footer -->

	<footer class="footer">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="/health/images/imageedit_15_5991094611.gif" data-speed="0.8"></div>
		<div class="footer_content">
			<div class="container">
			<div class="row">
				<div class="col text-center">
					<a name="contact"><div class="section_title" style="color: #fff"   >Contact</div></a>	
					<br>
					<br>
					<br><br>				
				</div>
			</div>
				<div class="row">

					
					<!-- Footer Contact -->
					<div class="col-lg-7 footer_col">
						<div class="footer_contact">
						<div class="callout callout-success">
							<div style="font-size: 20px;font-weight: 600; color: #fff;    margin-top: -25px;">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pour toutes questions, suggestions ou remarques n’hésitez pas à nous contacter en remplissant le formulaire ci-dessous :
							</div>
						</div>


							
							<div class="footer_contact_form_container">
								<form action="#" class="footer_contact_form" id="footer_contact_form">
									<div class="d-flex flex-xl-row flex-column align-items-center justify-content-between">
										<input type="text" class="footer_contact_input" placeholder="Nom" required="required">
										<input type="email" class="footer_contact_input" placeholder="E-mail" required="required">
									</div>
									<textarea class="footer_contact_input footer_contact_textarea" placeholder="Message" required="required"></textarea>
									<button class="footer_contact_button">Envoyer un message</button>
								</form>
							</div>
						</div>
					</div>
					

					<!-- Footer Hours -->
					<div class="col-lg-5  footer_col">
						<div class="footer_hours">
							<u     style="color: #f7f7f7;"><div class="footer_hours_title">Heures de travail </div></u>
							<ul class="hours_list">
								<li class="d-flex flex-row align-items-center justify-content-start">
									<div >Services Normaux :</div>
									<div class="ml-auto">Lundi – Vendredi</div>
									<div  class="ml-auto">8.00 – 16.30</div>
								</li>	
								<li class="d-flex flex-row align-items-center justify-content-start">
									<div >Services d'Urgence :</div>
									<div >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lundi – Dimanche</div>
									<div >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;24/24</div>
								</li>								
								
							</ul>
							<br><br>
							<div class="row">
							<u style="color: #f7f7f7;"><div class="col -md-6 footer_hours_title">Tél </div></u>
							<div  class="col -md-6 ml-auto " style="font-size: 14px;font-weight: 500;color: #FFFFFF;    margin-top: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;066968721122</div>
							</div>
							<br>
							<div class="row">
							<u style="color: #f7f7f7;"><div class="col -md-6 footer_hours_title">Email </div></u>
							<div  class="col -md-6 ml-auto " style="font-size: 14px;font-weight: 500;color: #FFFFFF;    margin-top: 5px;">chu@gmail.com</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer_bar">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="footer_bar_content d-flex flex-sm-row flex-column align-items-lg-center align-items-start justify-content-start">
						
							
							<a href="#nous" style="margin-left: 300px;" ><b>À propos</b></a>
						
							<a href="#service" style="margin-left: 200px;"><b>Services</b></a>
							
							<a href="#contact" style="margin-left: 200px;"><b>Contact</b></a>
							
						
			
				
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
</div>
<div id="app">
        @guest
        <vue-login></vue-login>
        @endguest
</div>	 
@endsection