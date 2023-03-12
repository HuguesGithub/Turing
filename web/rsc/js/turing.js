$(document).ready(function() {
	activateCriteriaEvents();
	
	// Réinitialisation complète de l'interface
	$('button[data-trigger="init"]').on('click', function(){
		$('.criteria div').removeClass('active');
		$('#panelCodes li').removeClass('bg-danger bg-dark bg-info');
		$('#panelCodes li').addClass('bg-light');
	});
	
	// Bannir les codes encore disponibles
	$('button[data-trigger="ban"]').on('click', function(){
		$('#panelCodes li.bg-light').addClass('bg-dark').removeClass('bg-light');
	});

	// Valider les codes encore disponibles. Normalement, qu'un seul.
	$('button[data-trigger="commit"]').on('click', function(){
		$('#panelCodes li.bg-light').addClass('bg-info').removeClass('bg-light');
	});
	
	$('button[data-trigger="dropdown"]').on('click', function(){
		$(this).toggleClass('show');
		$(this).next().toggleClass('show');
	});
	
	$('li.dropdown-item[data-trigger="click"]').on('click', function(){
		$(this).parent().toggleClass('show');
		$(this).parent().siblings().toggleClass('show');
		$(this).parent().siblings().html($(this).data('criteria-id'));
		getCriteriaTemplate($(this).data('criteria-id'), $(this).parent().data('criteria-rank'));
	});
});

/**----------------------------------------------
 * FUNCTION getCriteriaTemplate
 * ----------------------------------------------
 * Cette fonction permet d'aller chercher le template du critère et de l'afficher à l'écran.
 * Puis, on initialise les actions Ajax qui en dépendent.
 */
function getCriteriaTemplate(criteriaId, criteriaRank) {
	let obj = null;
    let data = {'action': 'dealWithAjax', 'criteriaId': criteriaId};
    // On a un appel ajax pour rechercher les équivalences au numéro
    $.post(
        ajaxurl,
        data,
        function(response) {
            try {
                obj = JSON.parse(response);
            } catch (e) {
                console.log("error: "+e);
                console.log(response);
            }
        }).done(function(response) {
            obj = JSON.parse(response);
			let html = obj['criteria'];
            $('div[data-criteria-display="'+criteriaRank+'"]').html(html);
			activateCriteriaEvents();
			$('button[data-trigger="init"]').trigger('click');
        });
}

/**----------------------------------------------
 * FUNCTION activateCriteriaEvents
 * ----------------------------------------------
 * Cette fonction permet d'activer les actions sur les critères.
 */
function activateCriteriaEvents() {
	// Ajout de la sélection d'un élément d'un critère. Mécanique similaire à des radio boutons
	$('.criteria div').unbind().on('click', function(){
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).siblings().removeClass('active');
			$(this).addClass('active');
		}
		applyCriteria();
	});
}

/**----------------------------------------------
 * FUNCTION applyCriteria
 * ----------------------------------------------
 * Cette fonction permet d'exclure les codes qui ne correspondent pas aux critères sélectionnés.
 */
function applyCriteria() {
	// On réinitialise tous les codes exclus du précédent filtre, pour le cas où on modifierait un critère déjà sélectionné
	$('#panelCodes li.bg-danger').each(function() {
		$(this).removeClass('bg-danger').addClass('bg-light');
	});

	// On parcourt la liste des critères ayant une option sélectionnée
	$('.criteria div.active').each(function(){
		// On en récupère les paramètres
		let firstCriteria = $(this).data('first');
		let secondCriteria = $(this).data('second');
		let operatorCriteria = $(this).data('operator');

		// On parcourt chaque code non exclu (donc, non bg-danger, non bg-dark et non bg-info)
		$('#panelCodes li.bg-light').each(function() {
			// On interroge l'objet pour récupérer les valeurs des critères
			let leftCriteria = getCriteriaValue($(this), firstCriteria);
			let rightCriteria = getCriteriaValue($(this), secondCriteria);

			// Selon l'opérateur du critère
			switch (operatorCriteria) {
				case '<' :
					// Premier inférieur strict au deuxième
					firstInferieurSecond($(this), leftCriteria, rightCriteria, true);
				break;
				case '<=' :
					// Premier inférieur strict au deuxième
					firstInferieurSecond($(this), leftCriteria, rightCriteria, false);
				break;
				case '=' :
					// Premier égal le deuxième 
					firstEgalSecond($(this), leftCriteria, rightCriteria);
				break;
				case '>' :
					// Premier supérieur strict au deuxième
					firstSuperieurSecond($(this), leftCriteria, rightCriteria, true);
				break;
				case '>=' :
					// Premier supérieur strict au deuxième
					firstSuperieurSecond($(this), leftCriteria, rightCriteria, false);
				break;
				case 'M' :
					// Premier modulo 2 égal au second
					firstModuloSecond($(this), leftCriteria, rightCriteria);
				break;
                case '*' :
                    // Premier présent second fois dans le code
                    firstAppearsSecond($(this), leftCriteria, rightCriteria);
                break;
                case 'S' :
                    // A-t-on une séquence correspondant au leftCriteria
                    checkSequence($(this), leftCriteria);
                break;
                case 'PI' :
                    // On cherche si on a first Pair et second Impair
                    checkEvenOdd($(this), leftCriteria, rightCriteria);
                break;
                case 'R' :
                    // first est vide, second indique si on cherche un Triple (3), un Double (2), ou pas de répétition (0)
					checkOccurrences($(this), rightCriteria);
                break;
                case 'J' :
                    // first est vide, second indique si on cherche des Jumeaux (1) ou pas de Jumeaux (0)
                    checkTwins($(this), rightCriteria);
                break;
                case 'C' :
                    // A-t-on first valeurs consécutives, second indique si on cherche des Croissantes (1) ou croissantes et décroissantes (0)
                    checkFlush($(this), leftCriteria, rightCriteria);
                break;
                // A développer
                case 'min' :
                    // La première valeur est-elle minimale stricte ?
                    checkMin($(this), firstCriteria, secondCriteria, true);
                break;
                case 'min=' :
                    // La première valeur est-elle minimale ?
                    checkMin($(this), firstCriteria, secondCriteria, false);
                break;
                case 'max' :
                    // La première valeur est-elle maximale stricte ?
                    checkMax($(this), firstCriteria, secondCriteria, true);
                break;
                case 'max=' :
                    // La première valeur est-elle maximale ?
                    checkMax($(this), firstCriteria, secondCriteria, false);
                break;
                case 'XXX' :
                    console.log('Opérateur '+operatorCriteria+' en cours de développement.');
                break;
				default :
					// On trace pour le cas où on aurait un nouvel opérateur.
					console.log('Opérateur '+operatorCriteria+' inconnu.');
				break;
			}
		});
	});
}

/**----------------------------------------------
 * FUNCTION checkMin
 * ----------------------------------------------
 * Cette fonction permet de checker que le premier élément est minimal.
 */
function checkMin(obj, firstCriteria, secondCriteria, blnStrict) {
    let leftCriteria = getCriteriaValue(obj, firstCriteria);
    let rightCriteria = 0;
    switch (secondCriteria) {
        case 'r&c' :
            rightCriteria = Math.min(obj.data('r')*1, obj.data('c')*1);
        break;
        case 't&r' :
            rightCriteria = Math.min(obj.data('t')*1, obj.data('r')*1);
        break;
        case 'c&t' :
            rightCriteria = Math.min(obj.data('c')*1, obj.data('t')*1);
        break;
    }
    console.log(leftCriteria);
    console.log(rightCriteria);
    console.log(blnStrict);

    if (blnStrict && leftCriteria>=rightCriteria || !blnStrict && leftCriteria>rightCriteria) {
        obj.addClass('bg-danger').removeClass('bg-light');
    }
}

/**----------------------------------------------
 * FUNCTION checkMin
 * ----------------------------------------------
 * Cette fonction permet de checker que le premier élément est maximl.
 */
function checkMax(obj, firstCriteria, secondCriteria, blnStrict) {
    let leftCriteria = getCriteriaValue(obj, firstCriteria);
    let rightCriteria = 5;
    switch (secondCriteria) {
        case 'r&c' :
            rightCriteria = Math.max(obj.data('r')*1, obj.data('c')*1);
        break;
        case 't&r' :
            rightCriteria = Math.max(obj.data('t')*1, obj.data('r')*1);
        break;
        case 'c&t' :
            rightCriteria = Math.max(obj.data('c')*1, obj.data('t')*1);
        break;
    }
    console.log(leftCriteria);
    console.log(rightCriteria);
    console.log(blnStrict);

    if (blnStrict && leftCriteria<=rightCriteria || !blnStrict && leftCriteria<rightCriteria) {
        obj.addClass('bg-danger').removeClass('bg-light');
    }
}

/**----------------------------------------------
 * FUNCTION checkFlush
 * ----------------------------------------------
 * Cette fonction permet de checker la présence de valeurs consécutives
 * croissantes ou non.
 */
function checkFlush(obj, leftCriteria, rightCriteria) {
    let digit1 = obj.html().substr(0, 1);
    let digit2 = obj.html().substr(1, 1);
    let digit3 = obj.html().substr(2, 1);

    if (leftCriteria==3) {
        if (rightCriteria==1) {
            if (!(digit1==digit2-1 && digit2==digit3-1)) {
                obj.addClass('bg-danger').removeClass('bg-light');
            }
        } else if(rightCriteria==0) {
            if (!(digit1==digit2-1 && digit2==digit3-1) && !(digit2==digit1-1 && digit3==digit2-1)) {
                obj.addClass('bg-danger').removeClass('bg-light');
            }
        }
    } else if (leftCriteria==2) {
        if (rightCriteria==1) {
            if (!(digit1==digit2-1 && digit2!=digit3-1 || digit2==digit3-1 && digit1!=digit2-1)) {
                obj.addClass('bg-danger').removeClass('bg-light');
            }
        } else if(rightCriteria==0) {
            if (!(digit1==digit2-1 && digit2!=digit3-1 || digit2==digit3-1 && digit1!=digit2-1)
                &&
                !(digit1-1==digit2 && digit2-1!=digit3 || digit2-1==digit3 && digit1-1!=digit2)) {
                obj.addClass('bg-danger').removeClass('bg-light');
            }
        }
    } else {
        if (rightCriteria==1) {
            if (digit1==digit2-1 || digit2==digit3-1) {
                obj.addClass('bg-danger').removeClass('bg-light');
            }
        } else if(rightCriteria==0) {
            if (digit1==digit2-1 || digit2==digit3-1 || digit1-1==digit2 || digit2-1==digit3) {
                obj.addClass('bg-danger').removeClass('bg-light');
            }
        }
    }
}

/**----------------------------------------------
 * FUNCTION checkTwins
 * ----------------------------------------------
 * Cette fonction permet de checker la présence de jumeaux ou non.
 */
function checkTwins(obj, rightCriteria) {
    let digit1 = obj.html().substr(0, 1);
    let digit2 = obj.html().substr(1, 1);
    let digit3 = obj.html().substr(2, 1);
    
    let blnOccTriple = (digit1==digit2 && digit1==digit3);
    let blnOccDouble = (!blnOccTriple && (digit1==digit2 || digit1==digit3 || digit2==digit3));

    if (rightCriteria==1 && !blnOccDouble || rightCriteria==0 && blnOccDouble) {
        obj.addClass('bg-danger').removeClass('bg-light');
    }
}

/**----------------------------------------------
 * FUNCTION checkOccurrences
 * ----------------------------------------------
 * Cette fonction permet de checker une occurrence double, triple ou aucune.
 */
function checkOccurrences(obj, rightCriteria) {
    let digit1 = obj.html().substr(0, 1);
    let digit2 = obj.html().substr(1, 1);
    let digit3 = obj.html().substr(2, 1);
	
	let blnOccTriple = (digit1==digit2 && digit1==digit3);
	let blnOccDouble = (!blnOccTriple && (digit1==digit2 || digit1==digit3 || digit2==digit3));
	let blnOccNulle  = (digit1!=digit2 && digit2!=digit3 && digit3!=digit1);
	
	if (rightCriteria==3 && !blnOccTriple || rightCriteria==2 && !blnOccDouble || rightCriteria==0 && !blnOccNulle) {
        obj.addClass('bg-danger').removeClass('bg-light');
	}
}

/**----------------------------------------------
 * FUNCTION checkEvenOdd
 * ----------------------------------------------
 * Cette fonction permet d'exclure un code qui ne comporte pas le nombre de pair/impair attendu.
 */
function checkEvenOdd(obj, leftCriteria, rightCriteria) {
    let nbEven = (obj.html().match(/[24]/g) || []).length;
    let nbOdd = (obj.html().match(/[135]/g) || []).length;
    
    if (leftCriteria!=nbEven && rightCriteria!=nbOdd) {
        obj.addClass('bg-danger').removeClass('bg-light');
    }
}

/**----------------------------------------------
 * FUNCTION checkSequence
 * ----------------------------------------------
 * Cette fonction permet d'exclure un code qui ne comporte pas une séquence spécifique.
 */
function checkSequence(obj, leftCriteria) {
    let digit1 = obj.html().substr(0, 1);
    let digit2 = obj.html().substr(1, 1);
    let digit3 = obj.html().substr(2, 1);
    // leftCriteria == 1, on cherche une Séquence croissante
    let blnCroissante = (digit1<digit2 && digit2<digit3);
    // leftCriteria == -1, on cherche une Séquence décroissante
    let blnDecroissante = (digit1>digit2 && digit2>digit3);
    // leftCriteria == 0, on cherche l'absence de Séquence
    if (leftCriteria==1 && !blnCroissante ||
        leftCriteria==-1 && !blnDecroissante ||
        leftCriteria==0 && (blnCroissante || blnDecroissante)) {
        obj.addClass('bg-danger').removeClass('bg-light');
    }
}
/**----------------------------------------------
 * FUNCTION firstAppearsSecond
 * ----------------------------------------------
 * Cette fonction permet d'exclure un code dont le leftCriteria n'apparait pas rightCriteria fois dans le code.
 */
function firstAppearsSecond(obj, leftCriteria, rightCriteria) {
    let regExp = new RegExp(leftCriteria, "g");    
    if ((obj.html().match(regExp) || []).length!=rightCriteria) {
        obj.addClass('bg-danger').removeClass('bg-light');
    }
}

/**----------------------------------------------
 * FUNCTION firstModuloSecond
 * ----------------------------------------------
 * @param obj le code qu'on teste
 * @param leftCriteria la valeur qu'on teste
 * @param rightCriteria le critère testé
 * ----------------------------------------------
 * Si rightCriteria vaut 1, on teste si leftCriteria est impair
 * Sinon, on teste si leftCriteria est un multiple de rightCriteria
 */
function firstModuloSecond(obj, leftCriteria, rightCriteria) {
    if (rightCriteria==1 && leftCriteria%2==0 || rightCriteria!=1 && leftCriteria%rightCriteria!=0) {
		obj.addClass('bg-danger').removeClass('bg-light');
    }
}

/**----------------------------------------------
 * FUNCTION firstSuperieurSecond
 * ----------------------------------------------
 * Cette fonction permet d'exclure un code dont le leftCriteria<=rightCriteria.
 * Si les paramètres sont des objets, on a des RegExp.
 */
function firstSuperieurSecond(obj, leftCriteria, rightCriteria, blnStrict) {
    if (typeof leftCriteria == 'object') {
        if ((obj.html().match(leftCriteria) || []).length <= (obj.html().match(rightCriteria) || []).length) {
            obj.addClass('bg-danger').removeClass('bg-light');
        }
    } else if (blnStrict && leftCriteria<=rightCriteria || !blnStrict && leftCriteria<rightCriteria) {
		obj.addClass('bg-danger').removeClass('bg-light');
	}
}

/**----------------------------------------------
 * FUNCTION firstEgalSecond
 * ----------------------------------------------
 * Cette fonction permet d'exclure un code dont le leftCriteria!=rightCriteria.
 */
function firstEgalSecond(obj, leftCriteria, rightCriteria) {
	if (leftCriteria!=rightCriteria) {
		obj.addClass('bg-danger').removeClass('bg-light');
	}
}

/**----------------------------------------------
 * FUNCTION firstInferieurSecond
 * ----------------------------------------------
 * Cette fonction permet d'exclure un code dont le leftCriteria>=rightCriteria.
 */
function firstInferieurSecond(obj, leftCriteria, rightCriteria, blnStrict) {
	if (typeof leftCriteria == 'object') {
        if ((obj.html().match(leftCriteria) || []).length >= (obj.html().match(rightCriteria) || []).length) {
            obj.addClass('bg-danger').removeClass('bg-light');
        }
    } else if (blnStrict && leftCriteria>=rightCriteria || !blnStrict && leftCriteria>rightCriteria) {
		obj.addClass('bg-danger').removeClass('bg-light');
	}
}

/**----------------------------------------------
 * FUNCTION getCriteriaValue
 * ----------------------------------------------
 * Cette fonction permet de récupérer la vlauer de l'élément à tester.
 */
function getCriteriaValue(obj, criteria) {
	let valeur = -10;
	switch (criteria) {
		// On récupère la valeur associé au paramètre
		case 't' :
		case 'c' :
		case 'r' :
			valeur = obj.data(criteria);
		break;
		// On récupère la somme des valeurs associées au paramètre
		case 't+c' :
			valeur = obj.data('t')*1+obj.data('c')*1;
		break;
		case 'c+r' :
			valeur = obj.data('c')*1+obj.data('r')*1;
		break;
		case 'r+t' :
			valeur = obj.data('r')*1+obj.data('t')*1;
		break;
		case 't+c+r' :
			valeur = obj.data('t')*1+obj.data('c')*1+obj.data('r')*1;
		break;
		// Un simple nombre
        case -1 :
		case 0 :
		case 1 :
		case 2 :
		case 3 :
		case 4 :
		case 5 :
		case 6 :
			valeur = criteria*1;
		break;
		// Des chiffres pairs
		case 'P' :
		  valeur = new RegExp(/[24]/g);
		break;
		// Des chiffres impairs
        case 'I' :
          valeur = new RegExp(/[135]/g);
        break;
        case 'r&c' :
            valeur = Math.min(obj.data('r')*1, obj.data('c')*1);
        break;
        case 't&r' :
            valeur = Math.min(obj.data('t')*1, obj.data('r')*1);
        break;
        case 'c&t' :
            valeur = Math.min(obj.data('c')*1, obj.data('t')*1);
        break;
        case '' :
        // A ignorer
          valeur = -10;
        break;
        // A développer
        case 'XXX' :
            console.log('Opérateur '+criteria+' en cours de développement.');
        break;
        // Non prévu pour le moment, on trace
		default :
			console.log('getCriteriaValue '+criteria+' non implémenté.');
		break; 
	}
	return valeur;
}