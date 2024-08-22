    <!-- Modal du niveau de difficulté -->
    <div class="modal fade bg-black" style="--bs-bg-opacity: .7;" id="difficulty_setting" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="difficulty_setting_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div id="difficulty_box" class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-center">
                    <h1 class="modal-title fs-2" id="difficulty_setting_title"> Niveaux de difficulté</h1>
                </div>
                <div class="modal-body">
                    <p class="fs-6"> Passez votre souris sur le niveau de votre choix pour plus d'info</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" id="easy_btn" class="btn btn btn-success fs-4 difficulty_level"
                        role="button" data-bs-toggle="popover" data-bs-trigger="hover focus"
                        data-bs-custom-class="custom-popover-easy" data-bs-placement="bottom" title="50% des points"
                        data-bs-content="Mot de 3 à 5 lettres" data-bs-dismiss="modal">
                        Facile
                        <svg fill="#FFFFFF" class="icon_btn" id="easy_svg" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15,16a3,3,0,1,1-3-3A3,3,0,0,1,15,16ZM16,5v5.262a7,7,0,1,1-8,0V5a4,4,0,0,1,8,0Zm-1.5,6.675a1,1,0,0,1-.5-.865V5a2,2,0,0,0-4,0v5.81a1,1,0,0,1-.5.865,5,5,0,1,0,5,0Z" />
                        </svg>
                    </button>

                    <button type="button" id="medium_btn" class="btn btn-warning fs-4 difficulty_level"
                        onhover="alert('test')" role="button" data-bs-toggle="popover" data-bs-trigger="hover focus"
                        data-bs-custom-class="custom-popover-medium" data-bs-placement="bottom" title="100% des points"
                        data-bs-content="Mot de 6 à 8 lettres"" data-bs-dismiss=" modal">
                        Moyen
                        <svg fill="#FFFFFF" class="icon_btn" id="medium_svg" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17,16a3,3,0,1,1-3-3A3,3,0,0,1,17,16Zm4,0a7,7,0,0,1-7.016,7,7.194,7.194,0,0,1-.827-.049,7.067,7.067,0,0,1-6.07-5.835A6.986,6.986,0,0,1,10,10.261V5a4,4,0,0,1,8,0v5.262A7.021,7.021,0,0,1,21,16Zm-2,0a5.016,5.016,0,0,0-2.5-4.325,1,1,0,0,1-.5-.865V5a2,2,0,0,0-4,0v5.81a1,1,0,0,1-.5.865A5,5,0,1,0,19,16ZM8,3H4A1,1,0,0,0,4,5H8A1,1,0,0,0,8,3ZM9,8A1,1,0,0,0,8,7H6A1,1,0,0,0,6,9H8A1,1,0,0,0,9,8Z" />
                        </svg>
                    </button>

                    <button type="button" id="hard_btn" class="btn btn btn-danger fs-4 difficulty_level"
                        role="button" data-bs-toggle="popover" data-bs-trigger="hover focus"
                        data-bs-custom-class="custom-popover-hard" data-bs-placement="bottom" title="200% des points"
                        data-bs-content="Mot de 9 à 12 lettres" data-bs-dismiss="modal">
                        Difficile
                        <svg fill="#FFFFFF" class="icon_btn" id="hard_svg" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11,16a2.99,2.99,0,0,1,2-2.816V5a1,1,0,0,1,2,0v8.184A2.995,2.995,0,1,1,11,16ZM10,5a4,4,0,0,1,8,0v5.262A7,7,0,0,1,13.984,23a7.177,7.177,0,0,1-.826-.049,7.067,7.067,0,0,1-6.071-5.835A6.986,6.986,0,0,1,10,10.261ZM9.063,16.809a5.038,5.038,0,0,0,4.328,4.155A5,5,0,0,0,19,16a5.013,5.013,0,0,0-2.5-4.325,1,1,0,0,1-.5-.865V5a2,2,0,0,0-4,0v5.81a1,1,0,0,1-.5.865A5,5,0,0,0,9.063,16.809ZM4,5H8A1,1,0,0,0,8,3H4A1,1,0,0,0,4,5ZM9,8A1,1,0,0,0,8,7H6A1,1,0,0,0,6,9H8A1,1,0,0,0,9,8Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
