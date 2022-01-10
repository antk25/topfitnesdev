// Utility function
function Util () {};

/* 
	class manipulation functions
*/
Util.hasClass = function(el, className) {
	return el.classList.contains(className);
};

Util.addClass = function(el, className) {
	var classList = className.split(' ');
 	el.classList.add(classList[0]);
 	if (classList.length > 1) Util.addClass(el, classList.slice(1).join(' '));
};

Util.removeClass = function(el, className) {
	var classList = className.split(' ');
	el.classList.remove(classList[0]);	
	if (classList.length > 1) Util.removeClass(el, classList.slice(1).join(' '));
};

Util.toggleClass = function(el, className, bool) {
	if(bool) Util.addClass(el, className);
	else Util.removeClass(el, className);
};

Util.setAttributes = function(el, attrs) {
  for(var key in attrs) {
    el.setAttribute(key, attrs[key]);
  }
};

/* 
  DOM manipulation
*/
Util.getChildrenByClassName = function(el, className) {
  var children = el.children,
    childrenByClass = [];
  for (var i = 0; i < children.length; i++) {
    if (Util.hasClass(children[i], className)) childrenByClass.push(children[i]);
  }
  return childrenByClass;
};

Util.is = function(elem, selector) {
  if(selector.nodeType){
    return elem === selector;
  }

  var qa = (typeof(selector) === 'string' ? document.querySelectorAll(selector) : selector),
    length = qa.length,
    returnArr = [];

  while(length--){
    if(qa[length] === elem){
      return true;
    }
  }

  return false;
};

/* 
	Animate height of an element
*/
Util.setHeight = function(start, to, element, duration, cb, timeFunction) {
	var change = to - start,
	    currentTime = null;

  var animateHeight = function(timestamp){  
    if (!currentTime) currentTime = timestamp;         
    var progress = timestamp - currentTime;
    if(progress > duration) progress = duration;
    var val = parseInt((progress/duration)*change + start);
    if(timeFunction) {
      val = Math[timeFunction](progress, start, to - start, duration);
    }
    element.style.height = val+"px";
    if(progress < duration) {
        window.requestAnimationFrame(animateHeight);
    } else {
    	if(cb) cb();
    }
  };
  
  //set the height of the element before starting animation -> fix bug on Safari
  element.style.height = start+"px";
  window.requestAnimationFrame(animateHeight);
};

/* 
	Smooth Scroll
*/

Util.scrollTo = function(final, duration, cb, scrollEl) {
  var element = scrollEl || window;
  var start = element.scrollTop || document.documentElement.scrollTop,
    currentTime = null;

  if(!scrollEl) start = window.scrollY || document.documentElement.scrollTop;
      
  var animateScroll = function(timestamp){
  	if (!currentTime) currentTime = timestamp;        
    var progress = timestamp - currentTime;
    if(progress > duration) progress = duration;
    var val = Math.easeInOutQuad(progress, start, final-start, duration);
    element.scrollTo(0, val);
    if(progress < duration) {
      window.requestAnimationFrame(animateScroll);
    } else {
      cb && cb();
    }
  };

  window.requestAnimationFrame(animateScroll);
};

/* 
  Focus utility classes
*/

//Move focus to an element
Util.moveFocus = function (element) {
  if( !element ) element = document.getElementsByTagName("body")[0];
  element.focus();
  if (document.activeElement !== element) {
    element.setAttribute('tabindex','-1');
    element.focus();
  }
};

/* 
  Misc
*/

Util.getIndexInArray = function(array, el) {
  return Array.prototype.indexOf.call(array, el);
};

Util.cssSupports = function(property, value) {
  if('CSS' in window) {
    return CSS.supports(property, value);
  } else {
    var jsProperty = property.replace(/-([a-z])/g, function (g) { return g[1].toUpperCase();});
    return jsProperty in document.body.style;
  }
};

// merge a set of user options into plugin defaults
// https://gomakethings.com/vanilla-javascript-version-of-jquery-extend/
Util.extend = function() {
  // Variables
  var extended = {};
  var deep = false;
  var i = 0;
  var length = arguments.length;

  // Check if a deep merge
  if ( Object.prototype.toString.call( arguments[0] ) === '[object Boolean]' ) {
    deep = arguments[0];
    i++;
  }

  // Merge the object into the extended object
  var merge = function (obj) {
    for ( var prop in obj ) {
      if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
        // If deep merge and property is an object, merge properties
        if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
          extended[prop] = extend( true, extended[prop], obj[prop] );
        } else {
          extended[prop] = obj[prop];
        }
      }
    }
  };

  // Loop through each object and conduct a merge
  for ( ; i < length; i++ ) {
    var obj = arguments[i];
    merge(obj);
  }

  return extended;
};

// Check if Reduced Motion is enabled
Util.osHasReducedMotion = function() {
  if(!window.matchMedia) return false;
  var matchMediaObj = window.matchMedia('(prefers-reduced-motion: reduce)');
  if(matchMediaObj) return matchMediaObj.matches;
  return false; // return false if not supported
}; 

/* 
	Polyfills
*/
//Closest() method
if (!Element.prototype.matches) {
	Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
	Element.prototype.closest = function(s) {
		var el = this;
		if (!document.documentElement.contains(el)) return null;
		do {
			if (el.matches(s)) return el;
			el = el.parentElement || el.parentNode;
		} while (el !== null && el.nodeType === 1); 
		return null;
	};
}

//Custom Event() constructor
if ( typeof window.CustomEvent !== "function" ) {

  function CustomEvent ( event, params ) {
    params = params || { bubbles: false, cancelable: false, detail: undefined };
    var evt = document.createEvent( 'CustomEvent' );
    evt.initCustomEvent( event, params.bubbles, params.cancelable, params.detail );
    return evt;
   }

  CustomEvent.prototype = window.Event.prototype;

  window.CustomEvent = CustomEvent;
}

/* 
	Animation curves
*/
Math.easeInOutQuad = function (t, b, c, d) {
	t /= d/2;
	if (t < 1) return c/2*t*t + b;
	t--;
	return -c/2 * (t*(t-2) - 1) + b;
};

Math.easeInQuart = function (t, b, c, d) {
	t /= d;
	return c*t*t*t*t + b;
};

Math.easeOutQuart = function (t, b, c, d) { 
  t /= d;
	t--;
	return -c * (t*t*t*t - 1) + b;
};

Math.easeInOutQuart = function (t, b, c, d) {
	t /= d/2;
	if (t < 1) return c/2*t*t*t*t + b;
	t -= 2;
	return -c/2 * (t*t*t*t - 2) + b;
};

Math.easeOutElastic = function (t, b, c, d) {
  var s=1.70158;var p=d*0.7;var a=c;
  if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
  if (a < Math.abs(c)) { a=c; var s=p/4; }
  else var s = p/(2*Math.PI) * Math.asin (c/a);
  return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
};


/* JS Utility Classes */

// make focus ring visible only for keyboard navigation (i.e., tab key) 
(function() {
  var focusTab = document.getElementsByClassName('js-tab-focus'),
    shouldInit = false,
    outlineStyle = false,
    eventDetected = false;

  function detectClick() {
    if(focusTab.length > 0) {
      resetFocusStyle(false);
      window.addEventListener('keydown', detectTab);
    }
    window.removeEventListener('mousedown', detectClick);
    outlineStyle = false;
    eventDetected = true;
  };

  function detectTab(event) {
    if(event.keyCode !== 9) return;
    resetFocusStyle(true);
    window.removeEventListener('keydown', detectTab);
    window.addEventListener('mousedown', detectClick);
    outlineStyle = true;
  };

  function resetFocusStyle(bool) {
    var outlineStyle = bool ? '' : 'none';
    for(var i = 0; i < focusTab.length; i++) {
      focusTab[i].style.setProperty('outline', outlineStyle);
    }
  };

  function initFocusTabs() {
    if(shouldInit) {
      if(eventDetected) resetFocusStyle(outlineStyle);
      return;
    }
    shouldInit = focusTab.length > 0;
    window.addEventListener('mousedown', detectClick);
  };

  initFocusTabs();
  window.addEventListener('initFocusTabs', initFocusTabs);
}());

function resetFocusTabsStyle() {
  window.dispatchEvent(new CustomEvent('initFocusTabs'));
};
// File#: _1_accordion
// Usage: codyhouse.co/license
(function() {
	var Accordion = function(element) {
		this.element = element;
		this.items = Util.getChildrenByClassName(this.element, 'js-accordion__item');
		this.version = this.element.getAttribute('data-version') ? '-'+this.element.getAttribute('data-version') : '';
		this.showClass = 'accordion'+this.version+'__item--is-open';
		this.animateHeight = (this.element.getAttribute('data-animation') == 'on');
		this.multiItems = !(this.element.getAttribute('data-multi-items') == 'off'); 
		// deep linking options
		this.deepLinkOn = this.element.getAttribute('data-deep-link') == 'on';
		// init accordion
		this.initAccordion();
	};

	Accordion.prototype.initAccordion = function() {
		//set initial aria attributes
		for( var i = 0; i < this.items.length; i++) {
			var button = this.items[i].getElementsByTagName('button')[0],
				content = this.items[i].getElementsByClassName('js-accordion__panel')[0],
				isOpen = Util.hasClass(this.items[i], this.showClass) ? 'true' : 'false';
			Util.setAttributes(button, {'aria-expanded': isOpen, 'aria-controls': 'accordion-content-'+i, 'id': 'accordion-header-'+i});
			Util.addClass(button, 'js-accordion__trigger');
			Util.setAttributes(content, {'aria-labelledby': 'accordion-header-'+i, 'id': 'accordion-content-'+i});
		}

		//listen for Accordion events
		this.initAccordionEvents();

		// check deep linking option
		this.initDeepLink();
	};

	Accordion.prototype.initAccordionEvents = function() {
		var self = this;

		this.element.addEventListener('click', function(event) {
			var trigger = event.target.closest('.js-accordion__trigger');
			//check index to make sure the click didn't happen inside a children accordion
			if( trigger && Util.getIndexInArray(self.items, trigger.parentElement) >= 0) self.triggerAccordion(trigger);
		});
	};

	Accordion.prototype.triggerAccordion = function(trigger) {
		var bool = (trigger.getAttribute('aria-expanded') === 'true');

		this.animateAccordion(trigger, bool, false);

		if(!bool && this.deepLinkOn) {
			history.replaceState(null, '', '#'+trigger.getAttribute('aria-controls'));
		}
	};

	Accordion.prototype.animateAccordion = function(trigger, bool, deepLink) {
		var self = this;
		var item = trigger.closest('.js-accordion__item'),
			content = item.getElementsByClassName('js-accordion__panel')[0],
			ariaValue = bool ? 'false' : 'true';

		if(!bool) Util.addClass(item, this.showClass);
		trigger.setAttribute('aria-expanded', ariaValue);
		self.resetContentVisibility(item, content, bool);

		if( !this.multiItems && !bool || deepLink) this.closeSiblings(item);
	};

	Accordion.prototype.resetContentVisibility = function(item, content, bool) {
		Util.toggleClass(item, this.showClass, !bool);
		content.removeAttribute("style");
		if(bool && !this.multiItems) { // accordion item has been closed -> check if there's one open to move inside viewport 
			this.moveContent();
		}
	};

	Accordion.prototype.closeSiblings = function(item) {
		//if only one accordion can be open -> search if there's another one open
		var index = Util.getIndexInArray(this.items, item);
		for( var i = 0; i < this.items.length; i++) {
			if(Util.hasClass(this.items[i], this.showClass) && i != index) {
				this.animateAccordion(this.items[i].getElementsByClassName('js-accordion__trigger')[0], true, false);
				return false;
			}
		}
	};

	Accordion.prototype.moveContent = function() { // make sure title of the accordion just opened is inside the viewport
		var openAccordion = this.element.getElementsByClassName(this.showClass);
		if(openAccordion.length == 0) return;
		var boundingRect = openAccordion[0].getBoundingClientRect();
		if(boundingRect.top < 0 || boundingRect.top > window.innerHeight) {
			var windowScrollTop = window.scrollY || document.documentElement.scrollTop;
			window.scrollTo(0, boundingRect.top + windowScrollTop);
		}
	};

	Accordion.prototype.initDeepLink = function() {
		if(!this.deepLinkOn) return;
		var hash = window.location.hash.substr(1);
		if(!hash || hash == '') return;
		var trigger = this.element.querySelector('.js-accordion__trigger[aria-controls="'+hash+'"]');
		if(trigger && trigger.getAttribute('aria-expanded') !== 'true') {
			this.animateAccordion(trigger, false, true);
			setTimeout(function(){trigger.scrollIntoView(true);});
		}
	};

	window.Accordion = Accordion;
	
	//initialize the Accordion objects
	var accordions = document.getElementsByClassName('js-accordion');
	if( accordions.length > 0 ) {
		for( var i = 0; i < accordions.length; i++) {
			(function(i){new Accordion(accordions[i]);})(i);
		}
	}
}());
// File#: _1_collapse
// Usage: codyhouse.co/license
(function() {
    var Collapse = function(element) {
        this.element = element;
        this.triggers = document.querySelectorAll('[aria-controls="'+this.element.getAttribute('id')+'"]');
        this.animate = this.element.getAttribute('data-collapse-animate') == 'on';
        this.animating = false;
        initCollapse(this);
    };

    function initCollapse(element) {
        if ( element.triggers ) {
            // set initial 'aria-expanded' attribute for trigger elements
            updateTriggers(element, !Util.hasClass(element.element, 'is-hidden'));

            // detect click on trigger elements
            for(var i = 0; i < element.triggers.length; i++) {
                element.triggers[i].addEventListener('click', function(event) {
                    event.preventDefault();
                    toggleVisibility(element);
                });
            }
        }

        // custom event
        element.element.addEventListener('collapseToggle', function(event){
            toggleVisibility(element);
        });
    };

    function toggleVisibility(element) {
        var bool = Util.hasClass(element.element, 'is-hidden');
        if(element.animating) return;
        element.animating = true;
        animateElement(element, bool);
        updateTriggers(element, bool);
    };

    function animateElement(element, bool) {
        // bool === true -> show content
        if(!element.animate || !window.requestAnimationFrame) {
            Util.toggleClass(element.element, 'is-hidden', !bool);
            element.animating = false;
            return;
        }

        // animate content height
        Util.removeClass(element.element, 'is-hidden');
        var initHeight = !bool ? element.element.offsetHeight: 0,
            finalHeight = !bool ? 0 : element.element.offsetHeight;

        Util.addClass(element.element, 'overflow-hidden');

        Util.setHeight(initHeight, finalHeight, element.element, 200, function(){
            if(!bool) Util.addClass(element.element, 'is-hidden');
            element.element.removeAttribute("style");
            Util.removeClass(element.element, 'overflow-hidden');
            element.animating = false;
        }, 'easeInOutQuad');
    };

    function updateTriggers(element, bool) {
        for(var i = 0; i < element.triggers.length; i++) {
            bool ? element.triggers[i].setAttribute('aria-expanded', 'true') : element.triggers[i].removeAttribute('aria-expanded');
        };
    };

    window.Collapse = Collapse;

    //initialize the Collapse objects
    var collapses = document.getElementsByClassName('js-collapse');
    if( collapses.length > 0 ) {
        for( var i = 0; i < collapses.length; i++) {
            new Collapse(collapses[i]);
        }
    }
}());
// File#: _1_confetti-button
// Usage: codyhouse.co/license
(function() {
  var ConfettiBtn = function(element) {
    this.element = element;
    this.btn = this.element.getElementsByClassName('js-confetti-btn__btn');
    this.icon = this.element.getElementsByClassName('js-confetti-btn__icon');
    this.animating = false;
    this.animationClass = 'confetti-btn--animate';
    this.positionVariables = '--conf-btn-click-';
    initConfettiBtn(this);
	};

  function initConfettiBtn(element) {
    if(element.btn.length < 1 || element.icon.length < 1) return;
    element.btn[0].addEventListener('click', function(event){
      if(element.animating) return;
      element.animating = true;
      setAnimationPosition(element, event);
      Util.addClass(element.element, element.animationClass);
      resetAnimation(element);
    });
  };

  function setAnimationPosition(element, event) { // change icon position based on click position
    
    var btnBoundingRect = element.btn[0].getBoundingClientRect();
    document.documentElement.style.setProperty(element.positionVariables+'x', (event.clientX - btnBoundingRect.left)+'px');
    document.documentElement.style.setProperty(element.positionVariables+'y', (event.clientY - btnBoundingRect.top)+'px');
  };

  function resetAnimation(element) { // reset the button at the end of the icon animation
    
    element.icon[0].addEventListener('animationend', function cb(){
      element.icon[0].removeEventListener('animationend', cb);
      Util.removeClass(element.element, element.animationClass);
      element.animating = false;
    });
  };

  var confettiBtn = document.getElementsByClassName('js-confetti-btn');
  if(confettiBtn.length > 0) {
    for(var i = 0; i < confettiBtn.length; i++) {
      (function(i){new ConfettiBtn(confettiBtn[i]);})(i);
    }
  }
}());
// File#: _1_custom-select
// Usage: codyhouse.co/license
(function() {
  // NOTE: you need the js code only when using the --custom-dropdown variation of the Custom Select component. Default version does nor require JS.

  var CustomSelect = function(element) {
    this.element = element;
    this.select = this.element.getElementsByTagName('select')[0];
    this.optGroups = this.select.getElementsByTagName('optgroup');
    this.options = this.select.getElementsByTagName('option');
    this.selectedOption = getSelectedOptionText(this);
    this.selectId = this.select.getAttribute('id');
    this.trigger = false;
    this.dropdown = false;
    this.customOptions = false;
    this.arrowIcon = this.element.getElementsByTagName('svg');
    this.label = document.querySelector('[for="'+this.selectId+'"]');

    this.optionIndex = 0; // used while building the custom dropdown

    initCustomSelect(this); // init markup
    initCustomSelectEvents(this); // init event listeners
  };

  function initCustomSelect(select) {
    // create the HTML for the custom dropdown element
    select.element.insertAdjacentHTML('beforeend', initButtonSelect(select) + initListSelect(select));

    // save custom elements
    select.dropdown = select.element.getElementsByClassName('js-select__dropdown')[0];
    select.trigger = select.element.getElementsByClassName('js-select__button')[0];
    select.customOptions = select.dropdown.getElementsByClassName('js-select__item');

    // hide default select
    Util.addClass(select.select, 'is-hidden');
    if(select.arrowIcon.length > 0 ) select.arrowIcon[0].style.display = 'none';

    // place dropdown
    placeDropdown(select);
  };

  function initCustomSelectEvents(select) {
    // option selection in dropdown
    initSelection(select);

    // click events
    select.trigger.addEventListener('click', function(){
      toggleCustomSelect(select, false);
    });
    if(select.label) {
      // move focus to custom trigger when clicking on <select> label
      select.label.addEventListener('click', function(){
        Util.moveFocus(select.trigger);
      });
    }
    // keyboard navigation
    select.dropdown.addEventListener('keydown', function(event){
      if(event.keyCode && event.keyCode == 38 || event.key && event.key.toLowerCase() == 'arrowup') {
        keyboardCustomSelect(select, 'prev', event);
      } else if(event.keyCode && event.keyCode == 40 || event.key && event.key.toLowerCase() == 'arrowdown') {
        keyboardCustomSelect(select, 'next', event);
      }
    });
    // native <select> element has been updated -> update custom select as well
    select.element.addEventListener('select-updated', function(event){
      resetCustomSelect(select);
    });
  };

  function toggleCustomSelect(select, bool) {
    var ariaExpanded;
    if(bool) {
      ariaExpanded = bool;
    } else {
      ariaExpanded = select.trigger.getAttribute('aria-expanded') == 'true' ? 'false' : 'true';
    }
    select.trigger.setAttribute('aria-expanded', ariaExpanded);
    if(ariaExpanded == 'true') {
      var selectedOption = getSelectedOption(select);
      Util.moveFocus(selectedOption); // fallback if transition is not supported
      select.dropdown.addEventListener('transitionend', function cb(){
        Util.moveFocus(selectedOption);
        select.dropdown.removeEventListener('transitionend', cb);
      });
      placeDropdown(select); // place dropdown based on available space
    }
  };

  function placeDropdown(select) {
    // remove placement classes to reset position
    Util.removeClass(select.dropdown, 'select__dropdown--right select__dropdown--up');
    var triggerBoundingRect = select.trigger.getBoundingClientRect();
    Util.toggleClass(select.dropdown, 'select__dropdown--right', (document.documentElement.clientWidth - 5 < triggerBoundingRect.left + select.dropdown.offsetWidth));
    // check if there's enough space up or down
    var moveUp = (window.innerHeight - triggerBoundingRect.bottom - 5) < triggerBoundingRect.top;
    Util.toggleClass(select.dropdown, 'select__dropdown--up', moveUp);
    // check if we need to set a max width
    var maxHeight = moveUp ? triggerBoundingRect.top - 20 : window.innerHeight - triggerBoundingRect.bottom - 20;
    // set max-height based on available space
    select.dropdown.setAttribute('style', 'max-height: '+maxHeight+'px; width: '+triggerBoundingRect.width+'px;');
  };

  function keyboardCustomSelect(select, direction, event) { // navigate custom dropdown with keyboard
    event.preventDefault();
    var index = Util.getIndexInArray(select.customOptions, document.activeElement);
    index = (direction == 'next') ? index + 1 : index - 1;
    if(index < 0) index = select.customOptions.length - 1;
    if(index >= select.customOptions.length) index = 0;
    Util.moveFocus(select.customOptions[index]);
  };

  function initSelection(select) { // option selection
    select.dropdown.addEventListener('click', function(event){
      var option = event.target.closest('.js-select__item');
      if(!option) return;
      selectOption(select, option);
    });
  };

  function selectOption(select, option) {
    if(option.hasAttribute('aria-selected') && option.getAttribute('aria-selected') == 'true') {
      // selecting the same option
      select.trigger.setAttribute('aria-expanded', 'false'); // hide dropdown
    } else {
      var selectedOption = select.dropdown.querySelector('[aria-selected="true"]');
      if(selectedOption) selectedOption.setAttribute('aria-selected', 'false');
      option.setAttribute('aria-selected', 'true');
      select.trigger.getElementsByClassName('js-select__label')[0].textContent = option.textContent;
      select.trigger.setAttribute('aria-expanded', 'false');
      // new option has been selected -> update native <select> element _ arai-label of trigger <button>
      updateNativeSelect(select, option.getAttribute('data-index'));
      updateTriggerAria(select);
    }
    // move focus back to trigger
    select.trigger.focus();
  };

  function updateNativeSelect(select, index) {
    select.select.selectedIndex = index;
    select.select.dispatchEvent(new CustomEvent('change', {bubbles: true})); // trigger change event
  };

  function updateTriggerAria(select) {
    select.trigger.setAttribute('aria-label', select.options[select.select.selectedIndex].innerHTML+', '+select.label.textContent);
  };

  function getSelectedOptionText(select) {// used to initialize the label of the custom select button
    var label = '';
    if('selectedIndex' in select.select) {
      label = select.options[select.select.selectedIndex].text;
    } else {
      label = select.select.querySelector('option[selected]').text;
    }
    return label;

  };

  function initButtonSelect(select) { // create the button element -> custom select trigger
    // check if we need to add custom classes to the button trigger
    var customClasses = select.element.getAttribute('data-trigger-class') ? ' '+select.element.getAttribute('data-trigger-class') : '';

    var label = select.options[select.select.selectedIndex].innerHTML+', '+select.label.textContent;

    var button = '<button type="button" class="js-select__button select__button'+customClasses+'" aria-label="'+label+'" aria-expanded="false" aria-controls="'+select.selectId+'-dropdown"><span aria-hidden="true" class="js-select__label select__label">'+select.selectedOption+'</span>';
    if(select.arrowIcon.length > 0 && select.arrowIcon[0].outerHTML) {
      var clone = select.arrowIcon[0].cloneNode(true);
      Util.removeClass(clone, 'select__icon');
      button = button +clone.outerHTML;
    }

    return button+'</button>';

  };

  function initListSelect(select) { // create custom select dropdown
    var list = '<div class="js-select__dropdown select__dropdown" aria-describedby="'+select.selectId+'-description" id="'+select.selectId+'-dropdown">';
    list = list + getSelectLabelSR(select);
    if(select.optGroups.length > 0) {
      for(var i = 0; i < select.optGroups.length; i++) {
        var optGroupList = select.optGroups[i].getElementsByTagName('option'),
          optGroupLabel = '<li><span class="select__item select__item--optgroup">'+select.optGroups[i].getAttribute('label')+'</span></li>';
        list = list + '<ul class="select__list" role="listbox">'+optGroupLabel+getOptionsList(select, optGroupList) + '</ul>';
      }
    } else {
      list = list + '<ul class="select__list" role="listbox">'+getOptionsList(select, select.options) + '</ul>';
    }
    return list;
  };

  function getSelectLabelSR(select) {
    if(select.label) {
      return '<p class="sr-only" id="'+select.selectId+'-description">'+select.label.textContent+'</p>'
    } else {
      return '';
    }
  };

  function resetCustomSelect(select) {
    // <select> element has been updated (using an external control) - update custom select
    var selectedOption = select.dropdown.querySelector('[aria-selected="true"]');
    if(selectedOption) selectedOption.setAttribute('aria-selected', 'false');
    var option = select.dropdown.querySelector('.js-select__item[data-index="'+select.select.selectedIndex+'"]');
    option.setAttribute('aria-selected', 'true');
    select.trigger.getElementsByClassName('js-select__label')[0].textContent = option.textContent;
    select.trigger.setAttribute('aria-expanded', 'false');
    updateTriggerAria(select);
  };

  function getOptionsList(select, options) {
    var list = '';
    for(var i = 0; i < options.length; i++) {
      var selected = options[i].hasAttribute('selected') ? ' aria-selected="true"' : ' aria-selected="false"';
      list = list + '<li><button type="button" class="reset js-select__item select__item select__item--option" role="option" data-value="'+options[i].value+'" '+selected+' data-index="'+select.optionIndex+'">'+options[i].text+'</button></li>';
      select.optionIndex = select.optionIndex + 1;
    };
    return list;
  };

  function getSelectedOption(select) {
    var option = select.dropdown.querySelector('[aria-selected="true"]');
    if(option) return option;
    else return select.dropdown.getElementsByClassName('js-select__item')[0];
  };

  function moveFocusToSelectTrigger(select) {
    if(!document.activeElement.closest('.js-select')) return
    select.trigger.focus();
  };

  function checkCustomSelectClick(select, target) { // close select when clicking outside it
    if( !select.element.contains(target) ) toggleCustomSelect(select, 'false');
  };

  //initialize the CustomSelect objects
  var customSelect = document.getElementsByClassName('js-select');
  if( customSelect.length > 0 ) {
    var selectArray = [];
    for( var i = 0; i < customSelect.length; i++) {
      (function(i){selectArray.push(new CustomSelect(customSelect[i]));})(i);
    }

    // listen for key events
    window.addEventListener('keyup', function(event){
      if( event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape' ) {
        // close custom select on 'Esc'
        selectArray.forEach(function(element){
          moveFocusToSelectTrigger(element); // if focus is within dropdown, move it to dropdown trigger
          toggleCustomSelect(element, 'false'); // close dropdown
        });
      }
    });
    // close custom select when clicking outside it
    window.addEventListener('click', function(event){
      selectArray.forEach(function(element){
        checkCustomSelectClick(element, event.target);
      });
    });
  }
}());
// File#: _1_details
// Usage: codyhouse.co/license
(function() {
  var Details = function(element, index) {
    this.element = element;
    this.summary = this.element.getElementsByClassName('js-details__summary')[0];
    this.details = this.element.getElementsByClassName('js-details__content')[0];
    this.htmlElSupported = 'open' in this.element;
    this.initDetails(index);
    this.initDetailsEvents();
  };

  Details.prototype.initDetails = function(index) {
    // init aria attributes
    Util.setAttributes(this.summary, {'aria-expanded': 'false', 'aria-controls': 'details--'+index, 'role': 'button'});
    Util.setAttributes(this.details, {'aria-hidden': 'true', 'id': 'details--'+index});
  };

  Details.prototype.initDetailsEvents = function() {
    var self = this;
    if( this.htmlElSupported ) { // browser supports the <details> element
      this.element.addEventListener('toggle', function(event){
        var ariaValues = self.element.open ? ['true', 'false'] : ['false', 'true'];
        // update aria attributes when details element status change (open/close)
        self.updateAriaValues(ariaValues);
      });
    } else { //browser does not support <details>
      this.summary.addEventListener('click', function(event){
        event.preventDefault();
        var isOpen = self.element.getAttribute('open'),
          ariaValues = [];

        isOpen ? self.element.removeAttribute('open') : self.element.setAttribute('open', 'true');
        ariaValues = isOpen ? ['false', 'true'] : ['true', 'false'];
        self.updateAriaValues(ariaValues);
      });
    }
  };

  Details.prototype.updateAriaValues = function(values) {
    this.summary.setAttribute('aria-expanded', values[0]);
    this.details.setAttribute('aria-hidden', values[1]);
  };

  //initialize the Details objects
  var detailsEl = document.getElementsByClassName('js-details');
  if( detailsEl.length > 0 ) {
    for( var i = 0; i < detailsEl.length; i++) {
      (function(i){new Details(detailsEl[i], i);})(i);
    }
  }
}());
// File#: _1_diagonal-movement
// Usage: codyhouse.co/license
/*
  Modified version of the jQuery-menu-aim plugin
  https://github.com/kamens/jQuery-menu-aim
  - Replaced jQuery with Vanilla JS
  - Minor changes
*/
(function() {
  var menuAim = function(opts) {
    init(opts);
  };

  window.menuAim = menuAim;

  function init(opts) {
    var activeRow = null,
      mouseLocs = [],
      lastDelayLoc = null,
      timeoutId = null,
      options = Util.extend({
        menu: '',
        rows: false, //if false, get direct children - otherwise pass nodes list
        submenuSelector: "*",
        submenuDirection: "right",
        tolerance: 75,  // bigger = more forgivey when entering submenu
        enter: function(){},
        exit: function(){},
        activate: function(){},
        deactivate: function(){},
        exitMenu: function(){}
      }, opts),
      menu = options.menu;

    var MOUSE_LOCS_TRACKED = 3,  // number of past mouse locations to track
      DELAY = 300;  // ms delay when user appears to be entering submenu

    /**
     * Keep track of the last few locations of the mouse.
     */
    var mouseMoveFallback = function(event) {
      (!window.requestAnimationFrame) ? mousemoveDocument(event) : window.requestAnimationFrame(function(){mousemoveDocument(event);});
    };

    var mousemoveDocument = function(e) {
      mouseLocs.push({x: e.pageX, y: e.pageY});

      if (mouseLocs.length > MOUSE_LOCS_TRACKED) {
        mouseLocs.shift();
      }
    };

    /**
     * Cancel possible row activations when leaving the menu entirely
     */
    var mouseleaveMenu = function() {
      if (timeoutId) {
        clearTimeout(timeoutId);
      }

      // If exitMenu is supplied and returns true, deactivate the
      // currently active row on menu exit.
      if (options.exitMenu(this)) {
        if (activeRow) {
          options.deactivate(activeRow);
        }

        activeRow = null;
      }
    };

    /**
     * Trigger a possible row activation whenever entering a new row.
     */
    var mouseenterRow = function() {
      if (timeoutId) {
        // Cancel any previous activation delays
        clearTimeout(timeoutId);
      }

      options.enter(this);
      possiblyActivate(this);
    },
    mouseleaveRow = function() {
      options.exit(this);
    };

    /*
     * Immediately activate a row if the user clicks on it.
     */
    var clickRow = function() {
      activate(this);
    };

    /**
     * Activate a menu row.
     */
    var activate = function(row) {
      if (row == activeRow) {
        return;
      }

      if (activeRow) {
        options.deactivate(activeRow);
      }

      options.activate(row);
      activeRow = row;
    };

    /**
     * Possibly activate a menu row. If mouse movement indicates that we
     * shouldn't activate yet because user may be trying to enter
     * a submenu's content, then delay and check again later.
     */
    var possiblyActivate = function(row) {
      var delay = activationDelay();

      if (delay) {
        timeoutId = setTimeout(function() {
          possiblyActivate(row);
        }, delay);
      } else {
        activate(row);
      }
    };

    /**
     * Return the amount of time that should be used as a delay before the
     * currently hovered row is activated.
     *
     * Returns 0 if the activation should happen immediately. Otherwise,
     * returns the number of milliseconds that should be delayed before
     * checking again to see if the row should be activated.
     */
    var activationDelay = function() {
      if (!activeRow || !Util.is(activeRow, options.submenuSelector)) {
        // If there is no other submenu row already active, then
        // go ahead and activate immediately.
        return 0;
      }

      function getOffset(element) {
        var rect = element.getBoundingClientRect();
        return { top: rect.top + window.pageYOffset, left: rect.left + window.pageXOffset };
      };

      var offset = getOffset(menu),
          upperLeft = {
              x: offset.left,
              y: offset.top - options.tolerance
          },
          upperRight = {
              x: offset.left + menu.offsetWidth,
              y: upperLeft.y
          },
          lowerLeft = {
              x: offset.left,
              y: offset.top + menu.offsetHeight + options.tolerance
          },
          lowerRight = {
              x: offset.left + menu.offsetWidth,
              y: lowerLeft.y
          },
          loc = mouseLocs[mouseLocs.length - 1],
          prevLoc = mouseLocs[0];

      if (!loc) {
        return 0;
      }

      if (!prevLoc) {
        prevLoc = loc;
      }

      if (prevLoc.x < offset.left || prevLoc.x > lowerRight.x || prevLoc.y < offset.top || prevLoc.y > lowerRight.y) {
        // If the previous mouse location was outside of the entire
        // menu's bounds, immediately activate.
        return 0;
      }

      if (lastDelayLoc && loc.x == lastDelayLoc.x && loc.y == lastDelayLoc.y) {
        // If the mouse hasn't moved since the last time we checked
        // for activation status, immediately activate.
        return 0;
      }

      // Detect if the user is moving towards the currently activated
      // submenu.
      //
      // If the mouse is heading relatively clearly towards
      // the submenu's content, we should wait and give the user more
      // time before activating a new row. If the mouse is heading
      // elsewhere, we can immediately activate a new row.
      //
      // We detect this by calculating the slope formed between the
      // current mouse location and the upper/lower right points of
      // the menu. We do the same for the previous mouse location.
      // If the current mouse location's slopes are
      // increasing/decreasing appropriately compared to the
      // previous's, we know the user is moving toward the submenu.
      //
      // Note that since the y-axis increases as the cursor moves
      // down the screen, we are looking for the slope between the
      // cursor and the upper right corner to decrease over time, not
      // increase (somewhat counterintuitively).
      function slope(a, b) {
        return (b.y - a.y) / (b.x - a.x);
      };

      var decreasingCorner = upperRight,
        increasingCorner = lowerRight;

      // Our expectations for decreasing or increasing slope values
      // depends on which direction the submenu opens relative to the
      // main menu. By default, if the menu opens on the right, we
      // expect the slope between the cursor and the upper right
      // corner to decrease over time, as explained above. If the
      // submenu opens in a different direction, we change our slope
      // expectations.
      if (options.submenuDirection == "left") {
        decreasingCorner = lowerLeft;
        increasingCorner = upperLeft;
      } else if (options.submenuDirection == "below") {
        decreasingCorner = lowerRight;
        increasingCorner = lowerLeft;
      } else if (options.submenuDirection == "above") {
        decreasingCorner = upperLeft;
        increasingCorner = upperRight;
      }

      var decreasingSlope = slope(loc, decreasingCorner),
        increasingSlope = slope(loc, increasingCorner),
        prevDecreasingSlope = slope(prevLoc, decreasingCorner),
        prevIncreasingSlope = slope(prevLoc, increasingCorner);

      if (decreasingSlope < prevDecreasingSlope && increasingSlope > prevIncreasingSlope) {
        // Mouse is moving from previous location towards the
        // currently activated submenu. Delay before activating a
        // new menu row, because user may be moving into submenu.
        lastDelayLoc = loc;
        return DELAY;
      }

      lastDelayLoc = null;
      return 0;
    };

    var reset = function(triggerDeactivate) {
      if (timeoutId) {
        clearTimeout(timeoutId);
      }

      if (activeRow && triggerDeactivate) {
        options.deactivate(activeRow);
      }

      activeRow = null;
    };

    var destroyInstance = function() {
      menu.removeEventListener('mouseleave', mouseleaveMenu);
      document.removeEventListener('mousemove', mouseMoveFallback);
      if(rows.length > 0) {
        for(var i = 0; i < rows.length; i++) {
          rows[i].removeEventListener('mouseenter', mouseenterRow);
          rows[i].removeEventListener('mouseleave', mouseleaveRow);
          rows[i].removeEventListener('click', clickRow);
        }
      }

    };

    /**
     * Hook up initial menu events
     */
    menu.addEventListener('mouseleave', mouseleaveMenu);
    var rows = (options.rows) ? options.rows : menu.children;
    if(rows.length > 0) {
      for(var i = 0; i < rows.length; i++) {(function(i){
        rows[i].addEventListener('mouseenter', mouseenterRow);
        rows[i].addEventListener('mouseleave', mouseleaveRow);
        rows[i].addEventListener('click', clickRow);
      })(i);}
    }

    document.addEventListener('mousemove', mouseMoveFallback);

    /* Reset/destroy menu */
    menu.addEventListener('reset', function(event){
      reset(event.detail);
    });
    menu.addEventListener('destroy', destroyInstance);
  };
}());


// File#: _1_emoji-feedback
// Usage: codyhouse.co/license
(function() {
  function initEmojiRate(element) {
    var commentSection = element.getElementsByClassName('js-emoji-rate__comment');
    if(commentSection.length == 0) return;
    element.addEventListener('change', function() {
      // show comment input if user selects one of the radio btns
      showComment(commentSection[0]);
    });
  };

  function showComment(comment) {
    if(!Util.hasClass(comment, 'is-hidden')) return;
    // reveal comment section
    Util.removeClass(comment, 'is-hidden');
    var initHeight = 0,
			finalHeight = comment.offsetHeight;
    if(window.requestAnimationFrame && !reducedMotion) {
      Util.setHeight(initHeight, finalHeight, comment, 200, function(){
        // move focus to textarea
        var textArea = comment.querySelector('textarea');
        if(textArea) textArea.focus();
        // remove inline style
        comment.style.height = '';
      }, 'easeInOutQuad');
    }
  };

  var emojiRate = document.getElementsByClassName('js-emoji-rate'),
    reducedMotion = Util.osHasReducedMotion();
  if( emojiRate.length > 0 ) {
		for( var i = 0; i < emojiRate.length; i++) {
			(function(i){initEmojiRate(emojiRate[i]);})(i);
		}
	}
}());
// File#: _1_expandable-side-navigation
// Usage: codyhouse.co/license
(function() {
  var Exsidenav = function(element) {
		this.element = element;
    this.controls = this.element.getElementsByClassName('js-exsidenav__control');
    this.index = 0;
		initExsidenav(this);
	};

  function initExsidenav(element) {
    // set aria attributes
    initAria(element);
    // detect click on control buttons
    element.element.addEventListener('click', function(event){
      var control = event.target.closest('.js-exsidenav__control');
      if(control) toggleNav(control);
    });
  };

  function initAria(element) {
    // set aria attributes -> aria-controls and aria-expanded
    var randomNum = getRandomInt(0, 1000);
    for(var i = 0; i < element.controls.length; i++) {
      var newId = 'exsidenav-'+randomNum+'-'+element.index,
        id = element.controls[i].nextElementSibling.getAttribute('id');
      if(!id) {
        id = newId;
        element.controls[i].nextElementSibling.setAttribute('id', newId);
      }
      element.index = element.index + 1;
      element.controls[i].setAttribute('aria-controls', id);
      if(!element.controls[i].getAttribute('aria-expanded')) element.controls[i].setAttribute('aria-expanded', 'false');
    }
  };

  function toggleNav(control) {
    // open/close sub list
    var bool = (control.getAttribute('aria-expanded') === 'true'),
      ariaValue = bool ? 'false' : 'true';
    control.setAttribute('aria-expanded', ariaValue);
  };

  function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); 
  };

  window.Exsidenav = Exsidenav;
	
	//initialize the Exsidenav objects
	var exsidenav = document.getElementsByClassName('js-exsidenav');
	if( exsidenav.length > 0 ) {
		for( var i = 0; i < exsidenav.length; i++) {
			(function(i){new Exsidenav(exsidenav[i]);})(i);
		}
	}
}());
// File#: _1_lazy-load
// Usage: codyhouse.co/license
(function() {
  var LazyLoad = function(elements) {
    this.elements = elements;
    initLazyLoad(this);
  };

  function initLazyLoad(asset) {
    if(lazySupported) setAssetsSrc(asset);
    else if(intersectionObsSupported) observeAssets(asset);
    else scrollAsset(asset);
  };

  function setAssetsSrc(asset) {
    for(var i = 0; i < asset.elements.length; i++) {
      if(asset.elements[i].getAttribute('data-bg') || asset.elements[i].tagName.toLowerCase() == 'picture') { // this could be an element with a bg image or a <source> element inside a <picture>
        observeSingleAsset(asset.elements[i]);
      } else {
        setSingleAssetSrc(asset.elements[i]);
      }
    }
  };

  function setSingleAssetSrc(img) {
    if(img.tagName.toLowerCase() == 'picture') {
      setPictureSrc(img);
    } else {
      setSrcSrcset(img);
      var bg = img.getAttribute('data-bg');
      if(bg) img.style.backgroundImage = bg;
      if(!lazySupported || bg) img.removeAttribute("loading");
    }
  };

  function setPictureSrc(picture) {
    var pictureChildren = picture.children;
    for(var i = 0; i < pictureChildren.length; i++) setSrcSrcset(pictureChildren[i]);
    picture.removeAttribute("loading");
  };

  function setSrcSrcset(img) {
    var src = img.getAttribute('data-src');
    if(src) img.src = src;
    var srcset = img.getAttribute('data-srcset');
    if(srcset) img.srcset = srcset;
  };

  function observeAssets(asset) {
    for(var i = 0; i < asset.elements.length; i++) {
      observeSingleAsset(asset.elements[i]);
    }
  };

  function observeSingleAsset(img) {
    if( !img.getAttribute('data-src') && !img.getAttribute('data-srcset') && !img.getAttribute('data-bg') && img.tagName.toLowerCase() != 'picture') return; // using the native lazyload with no need js lazy-loading

    var threshold = img.getAttribute('data-threshold') || '200px';
    var config = {rootMargin: threshold};
    var observer = new IntersectionObserver(observerLoadContent.bind(img), config);
    observer.observe(img);
  };

  function observerLoadContent(entries, observer) {
    if(entries[0].isIntersecting) {
      setSingleAssetSrc(this);
      observer.unobserve(this);
    }
  };

  function scrollAsset(asset) {
    asset.elements = Array.prototype.slice.call(asset.elements);
    asset.listening = false;
    asset.scrollListener = eventLazyLoad.bind(asset);
    document.addEventListener("scroll", asset.scrollListener);
    asset.resizeListener = eventLazyLoad.bind(asset);
    document.addEventListener("resize", asset.resizeListener);
    eventLazyLoad.bind(asset)(); // trigger before starting scrolling/resizing
  };

  function eventLazyLoad() {
    var self = this;
    if(self.listening) return;
    self.listening = true;
    setTimeout(function() {
      for(var i = 0; i < self.elements.length; i++) {
        if ((self.elements[i].getBoundingClientRect().top <= window.innerHeight && self.elements[i].getBoundingClientRect().bottom >= 0) && getComputedStyle(self.elements[i]).display !== "none") {
          setSingleAssetSrc(self.elements[i]);

          self.elements = self.elements.filter(function(image) {
            return image.hasAttribute("loading");
          });

          if (self.elements.length === 0) {
            if(self.scrollListener) document.removeEventListener("scroll", self.scrollListener);
            if(self.resizeListener) window.removeEventListener("resize", self.resizeListener);
          }
        }
      }
      self.listening = false;
    }, 200);
  };

  window.LazyLoad = LazyLoad;

  var lazyLoads = document.querySelectorAll('[loading="lazy"]'),
    lazySupported = 'loading' in HTMLImageElement.prototype,
    intersectionObsSupported = ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype);

  if( lazyLoads.length > 0 ) {
    new LazyLoad(lazyLoads);
  };

}());
// File#: _1_modal-window
// Usage: codyhouse.co/license
(function() {
	var Modal = function(element) {
		this.element = element;
		this.triggers = document.querySelectorAll('[aria-controls="'+this.element.getAttribute('id')+'"]');
		this.firstFocusable = null;
		this.lastFocusable = null;
		this.moveFocusEl = null; // focus will be moved to this element when modal is open
		this.modalFocus = this.element.getAttribute('data-modal-first-focus') ? this.element.querySelector(this.element.getAttribute('data-modal-first-focus')) : null;
		this.selectedTrigger = null;
		this.preventScrollEl = this.getPreventScrollEl();
		this.showClass = "modal--is-visible";
		this.initModal();
	};

	Modal.prototype.getPreventScrollEl = function() {
		var scrollEl = false;
		var querySelector = this.element.getAttribute('data-modal-prevent-scroll');
		if(querySelector) scrollEl = document.querySelector(querySelector);
		return scrollEl;
	};

	Modal.prototype.initModal = function() {
		var self = this;
		//open modal when clicking on trigger buttons
		if ( this.triggers ) {
			for(var i = 0; i < this.triggers.length; i++) {
				this.triggers[i].addEventListener('click', function(event) {
					event.preventDefault();
					if(Util.hasClass(self.element, self.showClass)) {
						self.closeModal();
						return;
					}
					self.selectedTrigger = event.target;
					self.showModal();
					self.initModalEvents();
				});
			}
		}

		// listen to the openModal event -> open modal without a trigger button
		this.element.addEventListener('openModal', function(event){
			if(event.detail) self.selectedTrigger = event.detail;
			self.showModal();
			self.initModalEvents();
		});

		// listen to the closeModal event -> close modal without a trigger button
		this.element.addEventListener('closeModal', function(event){
			if(event.detail) self.selectedTrigger = event.detail;
			self.closeModal();
		});

		// if modal is open by default -> initialise modal events
		if(Util.hasClass(this.element, this.showClass)) this.initModalEvents();
	};

	Modal.prototype.showModal = function() {
		var self = this;
		Util.addClass(this.element, this.showClass);
		this.getFocusableElements();
		if(this.moveFocusEl) {
			this.moveFocusEl.focus();
			// wait for the end of transitions before moving focus
			this.element.addEventListener("transitionend", function cb(event) {
				self.moveFocusEl.focus();
				self.element.removeEventListener("transitionend", cb);
			});
		}
		this.emitModalEvents('modalIsOpen');
		// change the overflow of the preventScrollEl
		if(this.preventScrollEl) this.preventScrollEl.style.overflow = 'hidden';
	};

	Modal.prototype.closeModal = function() {
		if(!Util.hasClass(this.element, this.showClass)) return;
		console.log('close')
		Util.removeClass(this.element, this.showClass);
		this.firstFocusable = null;
		this.lastFocusable = null;
		this.moveFocusEl = null;
		if(this.selectedTrigger) this.selectedTrigger.focus();
		//remove listeners
		this.cancelModalEvents();
		this.emitModalEvents('modalIsClose');
		// change the overflow of the preventScrollEl
		if(this.preventScrollEl) this.preventScrollEl.style.overflow = '';
	};

	Modal.prototype.initModalEvents = function() {
		//add event listeners
		this.element.addEventListener('keydown', this);
		this.element.addEventListener('click', this);
	};

	Modal.prototype.cancelModalEvents = function() {
		//remove event listeners
		this.element.removeEventListener('keydown', this);
		this.element.removeEventListener('click', this);
	};

	Modal.prototype.handleEvent = function (event) {
		switch(event.type) {
			case 'click': {
				this.initClick(event);
			}
			case 'keydown': {
				this.initKeyDown(event);
			}
		}
	};

	Modal.prototype.initKeyDown = function(event) {
		if( event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' ) {
			//trap focus inside modal
			this.trapFocus(event);
		} else if( (event.keyCode && event.keyCode == 13 || event.key && event.key == 'Enter') && event.target.closest('.js-modal__close')) {
			event.preventDefault();
			this.closeModal(); // close modal when pressing Enter on close button
		}	
	};

	Modal.prototype.initClick = function(event) {
		//close modal when clicking on close button or modal bg layer 
		if( !event.target.closest('.js-modal__close') && !Util.hasClass(event.target, 'js-modal') ) return;
		event.preventDefault();
		this.closeModal();
	};

	Modal.prototype.trapFocus = function(event) {
		if( this.firstFocusable == document.activeElement && event.shiftKey) {
			//on Shift+Tab -> focus last focusable element when focus moves out of modal
			event.preventDefault();
			this.lastFocusable.focus();
		}
		if( this.lastFocusable == document.activeElement && !event.shiftKey) {
			//on Tab -> focus first focusable element when focus moves out of modal
			event.preventDefault();
			this.firstFocusable.focus();
		}
	}

	Modal.prototype.getFocusableElements = function() {
		//get all focusable elements inside the modal
		var allFocusable = this.element.querySelectorAll(focusableElString);
		this.getFirstVisible(allFocusable);
		this.getLastVisible(allFocusable);
		this.getFirstFocusable();
	};

	Modal.prototype.getFirstVisible = function(elements) {
		//get first visible focusable element inside the modal
		for(var i = 0; i < elements.length; i++) {
			if( isVisible(elements[i]) ) {
				this.firstFocusable = elements[i];
				break;
			}
		}
	};

	Modal.prototype.getLastVisible = function(elements) {
		//get last visible focusable element inside the modal
		for(var i = elements.length - 1; i >= 0; i--) {
			if( isVisible(elements[i]) ) {
				this.lastFocusable = elements[i];
				break;
			}
		}
	};

	Modal.prototype.getFirstFocusable = function() {
		if(!this.modalFocus || !Element.prototype.matches) {
			this.moveFocusEl = this.firstFocusable;
			return;
		}
		var containerIsFocusable = this.modalFocus.matches(focusableElString);
		if(containerIsFocusable) {
			this.moveFocusEl = this.modalFocus;
		} else {
			this.moveFocusEl = false;
			var elements = this.modalFocus.querySelectorAll(focusableElString);
			for(var i = 0; i < elements.length; i++) {
				if( isVisible(elements[i]) ) {
					this.moveFocusEl = elements[i];
					break;
				}
			}
			if(!this.moveFocusEl) this.moveFocusEl = this.firstFocusable;
		}
	};

	Modal.prototype.emitModalEvents = function(eventName) {
		var event = new CustomEvent(eventName, {detail: this.selectedTrigger});
		this.element.dispatchEvent(event);
	};

	function isVisible(element) {
		return element.offsetWidth || element.offsetHeight || element.getClientRects().length;
	};

	window.Modal = Modal;

	//initialize the Modal objects
	var modals = document.getElementsByClassName('js-modal');
	// generic focusable elements string selector
	var focusableElString = '[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary';
	if( modals.length > 0 ) {
		var modalArrays = [];
		for( var i = 0; i < modals.length; i++) {
			(function(i){modalArrays.push(new Modal(modals[i]));})(i);
		}

		window.addEventListener('keydown', function(event){ //close modal window on esc
			if(event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape') {
				for( var i = 0; i < modalArrays.length; i++) {
					(function(i){modalArrays[i].closeModal();})(i);
				};
			}
		});
	}
}());
// File#: _1_notice
// Usage: codyhouse.co/license
(function() {
    function initNoticeEvents(notice) {
        notice.addEventListener('click', function(event){
            if(event.target.closest('.js-notice__hide-control')) {
                event.preventDefault();
                Util.addClass(notice, 'notice--hide');
            }
        });
    };

    var noticeElements = document.getElementsByClassName('js-notice');
    if(noticeElements.length > 0) {
        for(var i=0; i < noticeElements.length; i++) {(function(i){
            initNoticeEvents(noticeElements[i]);
        })(i);}
    }
}());
// File#: _1_progress-bar
// Usage: codyhouse.co/license
(function() {
  var ProgressBar = function(element) {
    this.element = element;
    this.fill = this.element.getElementsByClassName('progress-bar__fill')[0];
    this.label = this.element.getElementsByClassName('progress-bar__value');
    this.value = getProgressBarValue(this);
    // before checking if data-animation is set -> check for reduced motion
    updatedProgressBarForReducedMotion(this);
    this.animate = this.element.hasAttribute('data-animation') && this.element.getAttribute('data-animation') == 'on';
    this.animationDuration = this.element.hasAttribute('data-duration') ? this.element.getAttribute('data-duration') : 1000;
    // animation will run only on browsers supporting IntersectionObserver
    this.canAnimate = ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype);
    // this element is used to announce the percentage value to SR
    this.ariaLabel = this.element.getElementsByClassName('js-progress-bar__aria-value');
    // check if we need to update the bar color
    this.changeColor =  Util.hasClass(this.element, 'progress-bar--color-update') && Util.cssSupports('color', 'var(--color-value)');
    if(this.changeColor) {
      this.colorThresholds = getProgressBarColorThresholds(this);
    }
    initProgressBar(this);
    // store id to reset animation
    this.animationId = false;
  };

  // public function
  ProgressBar.prototype.setProgressBarValue = function(value) {
    setProgressBarValue(this, value);
  };

  function getProgressBarValue(progressBar) { // get progress value
    // return (fill width/total width) * 100
    return parseFloat(progressBar.fill.offsetWidth*100/progressBar.element.getElementsByClassName('progress-bar__bg')[0].offsetWidth);
  };

  function getProgressBarColorThresholds(progressBar) {
    var thresholds = [];
    var i = 1;
    while (!isNaN(parseInt(getComputedStyle(progressBar.element).getPropertyValue('--progress-bar-color-'+i)))) {
      thresholds.push(parseInt(getComputedStyle(progressBar.element).getPropertyValue('--progress-bar-color-'+i)));
      i = i + 1;
    }
    return thresholds;
  };

  function updatedProgressBarForReducedMotion(progressBar) {
    // if reduced motion is supported and set to reduced -> remove animations
    if(osHasReducedMotion) progressBar.element.removeAttribute('data-animation');
  };

  function initProgressBar(progressBar) {
    // set initial bar color
    if(progressBar.changeColor) updateProgressBarColor(progressBar, progressBar.value);
    // if data-animation is on -> reset the progress bar and animate when entering the viewport
    if(progressBar.animate && progressBar.canAnimate) animateProgressBar(progressBar);
    // reveal fill and label -> --animate and --color-update variations only
    setTimeout(function(){Util.addClass(progressBar.element, 'progress-bar--init');}, 30);

    // dynamically update value of progress bar
    progressBar.element.addEventListener('updateProgress', function(event){
      // cancel request animation frame if it was animating
      if(progressBar.animationId) window.cancelAnimationFrame(progressBar.animationId);

      var final = event.detail.value,
        duration = (event.detail.duration) ? event.detail.duration : progressBar.animationDuration;
      var start = getProgressBarValue(progressBar);
      // trigger update animation
      updateProgressBar(progressBar, start, final, duration, function(){
        emitProgressBarEvents(progressBar, 'progressCompleted', progressBar.value+'%');
        // update value of label for SR
        if(progressBar.ariaLabel.length > 0) progressBar.ariaLabel[0].textContent = final+'%';
      });
    });
  };

  function animateProgressBar(progressBar) {
    // reset inital values
    setProgressBarValue(progressBar, 0);

    // listen for the element to enter the viewport -> start animation
    var observer = new IntersectionObserver(progressBarObserve.bind(progressBar), { threshold: [0, 0.1] });
    observer.observe(progressBar.element);
  };

  function progressBarObserve(entries, observer) { // observe progressBar position -> start animation when inside viewport
    var self = this;
    if(entries[0].intersectionRatio.toFixed(1) > 0 && !this.animationTriggered) {
      updateProgressBar(this, 0, this.value, this.animationDuration, function(){
        emitProgressBarEvents(self, 'progressCompleted', self.value+'%');
      });
    }
  };

  function updateProgressBar(progressBar, start, to, duration, cb) {
    var change = to - start,
      currentTime = null;

    var animateFill = function(timestamp){
      if (!currentTime) currentTime = timestamp;
      var progress = timestamp - currentTime;
      var val = parseInt((progress/duration)*change + start);
      // make sure value is in correct range
      if(change > 0 && val > to) val = to;
      if(change < 0 && val < to) val = to;
      if(progress >= duration) val = to;

      setProgressBarValue(progressBar, val);
      if(progress < duration) {
        progressBar.animationId = window.requestAnimationFrame(animateFill);
      } else {
        progressBar.animationId = false;
        cb();
      }
    };
    if ( window.requestAnimationFrame && !osHasReducedMotion ) {
      progressBar.animationId = window.requestAnimationFrame(animateFill);
    } else {
      setProgressBarValue(progressBar, to);
      cb();
    }
  };

  function setProgressBarValue(progressBar, value) {
    progressBar.fill.style.width = value+'%';
    if(progressBar.label.length > 0 ) progressBar.label[0].textContent = value+'%';
    if(progressBar.changeColor) updateProgressBarColor(progressBar, value);
  };

  function updateProgressBarColor(progressBar, value) {
    var className = 'progress-bar--fill-color-'+ progressBar.colorThresholds.length;
    for(var i = progressBar.colorThresholds.length; i > 0; i--) {
      if( !isNaN(progressBar.colorThresholds[i - 1]) && value <= progressBar.colorThresholds[i - 1]) {
        className = 'progress-bar--fill-color-' + i;
      }
    }

    removeProgressBarColorClasses(progressBar);
    Util.addClass(progressBar.element, className);
  };

  function removeProgressBarColorClasses(progressBar) {
    var classes = progressBar.element.className.split(" ").filter(function(c) {
      return c.lastIndexOf('progress-bar--fill-color-', 0) !== 0;
    });
    progressBar.element.className = classes.join(" ").trim();
  };

  function emitProgressBarEvents(progressBar, eventName, detail) {
    progressBar.element.dispatchEvent(new CustomEvent(eventName, {detail: detail}));
  };

  window.ProgressBar = ProgressBar;

  //initialize the ProgressBar objects
  var progressBars = document.getElementsByClassName('js-progress-bar');
  var osHasReducedMotion = Util.osHasReducedMotion();
  if( progressBars.length > 0 ) {
    for( var i = 0; i < progressBars.length; i++) {
      (function(i){new ProgressBar(progressBars[i]);})(i);
    }
  }
}());
// File#: _1_rating
// Usage: codyhouse.co/license
(function() {
  var Rating = function(element) {
    this.element = element;
    this.icons = this.element.getElementsByClassName('js-rating__control')[0];
    this.iconCode = this.icons.children[0].parentNode.innerHTML;
    this.initialRating = [];
    this.initialRatingElement = this.element.getElementsByClassName('js-rating__value')[0];
    this.ratingItems;
    this.selectedRatingItem;
    this.readOnly = Util.hasClass(this.element, 'js-rating--read-only');
    this.ratingMaxValue = 5;
    this.getInitialRating();
    this.initRatingHtml();
  };

  Rating.prototype.getInitialRating = function() {
    // get the rating of the product
    if(!this.initialRatingElement || !this.readOnly) {
      this.initialRating = [0, false];
      return;
    }

    var initialValue = Number(this.initialRatingElement.textContent);
    if(isNaN(initialValue)) {
      this.initialRating = [0, false];
      return;
    }

    var floorNumber = Math.floor(initialValue);
    this.initialRating[0] = (floorNumber < initialValue) ? floorNumber + 1 : floorNumber;
    this.initialRating[1] = (floorNumber < initialValue) ? Math.round((initialValue - floorNumber)*100) : false;
  };

  Rating.prototype.initRatingHtml = function() {
    //create the star elements
    var iconsList = this.readOnly ? '<ul>' : '<ul role="radiogroup">';

    //if initial rating value is zero -> add a 'zero' item
    if(this.initialRating[0] == 0 && !this.initialRating[1]) {
      iconsList = iconsList+ '<li class="rating__item--zero rating__item--checked"></li>';
    }

    // create the stars list
    for(var i = 0; i < this.ratingMaxValue; i++) {
      iconsList = iconsList + this.getStarHtml(i);
    }
    iconsList = iconsList + '</ul>';

    // --default variation only - improve SR accessibility including a legend element
    if(!this.readOnly) {
      var labelElement = this.element.getElementsByTagName('label');
      if(labelElement.length > 0) {
        var legendElement = '<legend class="'+labelElement[0].getAttribute('class')+'">'+labelElement[0].textContent+'</legend>';
        iconsList = '<fieldset>'+legendElement+iconsList+'</fieldset>';
        Util.addClass(labelElement[0], 'is-hidden');
      }
    }

    this.icons.innerHTML = iconsList;

    //init object properties
    this.ratingItems = this.icons.getElementsByClassName('js-rating__item');
    this.selectedRatingItem = this.icons.getElementsByClassName('rating__item--checked')[0];

    //show the stars
    Util.removeClass(this.icons, 'rating__control--is-hidden');

    //event listener
    !this.readOnly && this.initRatingEvents();// rating vote enabled
  };

  Rating.prototype.getStarHtml = function(index) {
    var listItem = '';
    var checked = (index+1 == this.initialRating[0]) ? true : false,
      itemClass = checked ? ' rating__item--checked' : '',
      tabIndex = (checked || (this.initialRating[0] == 0 && !this.initialRating[1] && index == 0) ) ? 0 : -1,
      showHalf = checked && this.initialRating[1] ? true : false,
      iconWidth = showHalf ? ' rating__item--half': '';
    if(!this.readOnly) {
      listItem = '<li class="js-rating__item'+itemClass+iconWidth+'" role="radio" aria-label="'+(index+1)+'" aria-checked="'+checked+'" tabindex="'+tabIndex+'"><div class="rating__icon">'+this.iconCode+'</div></li>';
    } else {
      var starInner = showHalf ? '<div class="rating__icon">'+this.iconCode+'</div><div class="rating__icon rating__icon--inactive">'+this.iconCode+'</div>': '<div class="rating__icon">'+this.iconCode+'</div>';
      listItem = '<li class="js-rating__item'+itemClass+iconWidth+'">'+starInner+'</li>';
    }
    return listItem;
  };

  Rating.prototype.initRatingEvents = function() {
    var self = this;

    //click on a star
    this.icons.addEventListener('click', function(event){
      var trigger = event.target.closest('.js-rating__item');
      self.resetSelectedIcon(trigger);
    });

    //keyboard navigation -> select new star
    this.icons.addEventListener('keydown', function(event){
      if( event.keyCode && (event.keyCode == 39 || event.keyCode == 40 ) || event.key && (event.key.toLowerCase() == 'arrowright' || event.key.toLowerCase() == 'arrowdown') ) {
        self.selectNewIcon('next'); //select next star on arrow right/down
      } else if(event.keyCode && (event.keyCode == 37 || event.keyCode == 38 ) || event.key && (event.key.toLowerCase() == 'arrowleft' || event.key.toLowerCase() == 'arrowup')) {
        self.selectNewIcon('prev'); //select prev star on arrow left/up
      } else if(event.keyCode && event.keyCode == 32 || event.key && event.key == ' ') {
        self.selectFocusIcon(); // select focused star on Space
      }
    });
  };

  Rating.prototype.selectNewIcon = function(direction) {
    var index = Util.getIndexInArray(this.ratingItems, this.selectedRatingItem);
    index = (direction == 'next') ? index + 1 : index - 1;
    if(index < 0) index = this.ratingItems.length - 1;
    if(index >= this.ratingItems.length) index = 0;
    this.resetSelectedIcon(this.ratingItems[index]);
    this.ratingItems[index].focus();
  };

  Rating.prototype.selectFocusIcon = function(direction) {
    this.resetSelectedIcon(document.activeElement);
  };

  Rating.prototype.resetSelectedIcon = function(trigger) {
    if(!trigger) return;
    Util.removeClass(this.selectedRatingItem, 'rating__item--checked');
    Util.setAttributes(this.selectedRatingItem, {'aria-checked': false, 'tabindex': -1});
    Util.addClass(trigger, 'rating__item--checked');
    Util.setAttributes(trigger, {'aria-checked': true, 'tabindex': 0});
    this.selectedRatingItem = trigger;
    // update select input value
    var select = this.element.getElementsByTagName('select');
    if(select.length > 0) {
      select[0].value = trigger.getAttribute('aria-label');
    }
  };

  //initialize the Rating objects
  var ratings = document.getElementsByClassName('js-rating');
  if( ratings.length > 0 ) {
    for( var i = 0; i < ratings.length; i++) {
      (function(i){new Rating(ratings[i]);})(i);
    }
  };
}());
// File#: _1_read-more
// Usage: codyhouse.co/license
(function() {
  var ReadMore = function(element) {
    this.element = element;
    this.moreContent = this.element.getElementsByClassName('js-read-more__content');
    this.count = this.element.getAttribute('data-characters') || 200;
    this.counting = 0;
    this.btnClasses = this.element.getAttribute('data-btn-class');
    this.ellipsis = this.element.getAttribute('data-ellipsis') && this.element.getAttribute('data-ellipsis') == 'off' ? false : true;
    this.btnShowLabel = 'Read more';
    this.btnHideLabel = 'Read less';
    this.toggleOff = this.element.getAttribute('data-toggle') && this.element.getAttribute('data-toggle') == 'off' ? false : true;
    if( this.moreContent.length == 0 ) splitReadMore(this);
    setBtnLabels(this);
    initReadMore(this);
  };

  function splitReadMore(readMore) {
    splitChildren(readMore.element, readMore); // iterate through children and hide content
  };

  function splitChildren(parent, readMore) {
    if(readMore.counting >= readMore.count) {
      Util.addClass(parent, 'js-read-more__content');
      return parent.outerHTML;
    }
    var children = parent.childNodes;
    var content = '';
    for(var i = 0; i < children.length; i++) {
      if (children[i].nodeType == Node.TEXT_NODE) {
        content = content + wrapText(children[i], readMore);
      } else {
        content = content + splitChildren(children[i], readMore);
      }
    }
    parent.innerHTML = content;
    return parent.outerHTML;
  };

  function wrapText(element, readMore) {
    var content = element.textContent;
    if(content.replace(/\s/g,'').length == 0) return '';// check if content is empty
    if(readMore.counting >= readMore.count) {
      return '<span class="js-read-more__content">' + content + '</span>';
    }
    if(readMore.counting + content.length < readMore.count) {
      readMore.counting = readMore.counting + content.length;
      return content;
    }
    var firstContent = content.substr(0, readMore.count - readMore.counting);
    firstContent = firstContent.substr(0, Math.min(firstContent.length, firstContent.lastIndexOf(" ")));
    var secondContent = content.substr(firstContent.length, content.length);
    readMore.counting = readMore.count;
    return firstContent + '<span class="js-read-more__content">' + secondContent + '</span>';
  };

  function setBtnLabels(readMore) { // set custom labels for read More/Less btns
    var btnLabels = readMore.element.getAttribute('data-btn-labels');
    if(btnLabels) {
      var labelsArray = btnLabels.split(',');
      readMore.btnShowLabel = labelsArray[0].trim();
      readMore.btnHideLabel = labelsArray[1].trim();
    }
  };

  function initReadMore(readMore) { // add read more/read less buttons to the markup
    readMore.moreContent = readMore.element.getElementsByClassName('js-read-more__content');
    if( readMore.moreContent.length == 0 ) {
      Util.addClass(readMore.element, 'read-more--loaded');
      return;
    }
    var btnShow = ' <button class="js-read-more__btn '+readMore.btnClasses+'">'+readMore.btnShowLabel+'</button>';
    var btnHide = ' <button class="js-read-more__btn is-hidden '+readMore.btnClasses+'">'+readMore.btnHideLabel+'</button>';
    if(readMore.ellipsis) {
      btnShow = '<span class="js-read-more__ellipsis" aria-hidden="true">...</span>'+ btnShow;
    }

    readMore.moreContent[readMore.moreContent.length - 1].insertAdjacentHTML('afterend', btnHide);
    readMore.moreContent[0].insertAdjacentHTML('afterend', btnShow);
    resetAppearance(readMore);
    initEvents(readMore);
  };

  function resetAppearance(readMore) { // hide part of the content
    for(var i = 0; i < readMore.moreContent.length; i++) Util.addClass(readMore.moreContent[i], 'is-hidden');
    Util.addClass(readMore.element, 'read-more--loaded'); // show entire component
  };

  function initEvents(readMore) { // listen to the click on the read more/less btn
    readMore.btnToggle = readMore.element.getElementsByClassName('js-read-more__btn');
    readMore.ellipsis = readMore.element.getElementsByClassName('js-read-more__ellipsis');

    readMore.btnToggle[0].addEventListener('click', function(event){
      event.preventDefault();
      updateVisibility(readMore, true);
    });
    readMore.btnToggle[1].addEventListener('click', function(event){
      event.preventDefault();
      updateVisibility(readMore, false);
    });
  };

  function updateVisibility(readMore, visibile) {
    for(var i = 0; i < readMore.moreContent.length; i++) Util.toggleClass(readMore.moreContent[i], 'is-hidden', !visibile);
    // reset btns appearance
    Util.toggleClass(readMore.btnToggle[0], 'is-hidden', visibile);
    Util.toggleClass(readMore.btnToggle[1], 'is-hidden', !visibile);
    if(readMore.ellipsis.length > 0 ) Util.toggleClass(readMore.ellipsis[0], 'is-hidden', visibile);
    if(!readMore.toggleOff) Util.addClass(readMore.btn, 'is-hidden');
    // move focus
    if(visibile) {
      var targetTabIndex = readMore.moreContent[0].getAttribute('tabindex');
      Util.moveFocus(readMore.moreContent[0]);
      resetFocusTarget(readMore.moreContent[0], targetTabIndex);
    } else {
      Util.moveFocus(readMore.btnToggle[0]);
    }
  };

  function resetFocusTarget(target, tabindex) {
    if( parseInt(target.getAttribute('tabindex')) < 0) {
      target.style.outline = 'none';
      !tabindex && target.removeAttribute('tabindex');
    }
  };

  //initialize the ReadMore objects
  var readMore = document.getElementsByClassName('js-read-more');
  if( readMore.length > 0 ) {
    for( var i = 0; i < readMore.length; i++) {
      (function(i){new ReadMore(readMore[i]);})(i);
    }
  };
}());
// File#: _1_responsive-sidebar
// Usage: codyhouse.co/license
(function() {
  var Sidebar = function(element) {
		this.element = element;
		this.triggers = document.querySelectorAll('[aria-controls="'+this.element.getAttribute('id')+'"]');
		this.firstFocusable = null;
		this.lastFocusable = null;
		this.selectedTrigger = null;
    this.showClass = "sidebar--is-visible";
    this.staticClass = "sidebar--static";
    this.customStaticClass = "";
    this.readyClass = "sidebar--loaded";
    this.contentReadyClass = "sidebar-loaded:show";
    this.layout = false; // this will be static or mobile
    getCustomStaticClass(this); // custom classes for static version
    initSidebar(this);
  };

  function getCustomStaticClass(element) {
    var customClasses = element.element.getAttribute('data-static-class');
    if(customClasses) element.customStaticClass = ' '+customClasses;
  };
  
  function initSidebar(sidebar) {
    initSidebarResize(sidebar); // handle changes in layout -> mobile to static and viceversa
    
		if ( sidebar.triggers ) { // open sidebar when clicking on trigger buttons - mobile layout only
			for(var i = 0; i < sidebar.triggers.length; i++) {
				sidebar.triggers[i].addEventListener('click', function(event) {
					event.preventDefault();
					if(Util.hasClass(sidebar.element, sidebar.showClass)) {
            sidebar.selectedTrigger = event.target;
            closeSidebar(sidebar);
            return;
          }
					sidebar.selectedTrigger = event.target;
					showSidebar(sidebar);
					initSidebarEvents(sidebar);
				});
			}
		}
  };

  function showSidebar(sidebar) { // mobile layout only
		Util.addClass(sidebar.element, sidebar.showClass);
		getFocusableElements(sidebar);
		Util.moveFocus(sidebar.element);
  };

  function closeSidebar(sidebar) { // mobile layout only
		Util.removeClass(sidebar.element, sidebar.showClass);
		sidebar.firstFocusable = null;
		sidebar.lastFocusable = null;
    if(sidebar.selectedTrigger) sidebar.selectedTrigger.focus();
    sidebar.element.removeAttribute('tabindex');
		//remove listeners
		cancelSidebarEvents(sidebar);
	};

  function initSidebarEvents(sidebar) { // mobile layout only
    //add event listeners
		sidebar.element.addEventListener('keydown', handleEvent.bind(sidebar));
		sidebar.element.addEventListener('click', handleEvent.bind(sidebar));
  };

  function cancelSidebarEvents(sidebar) { // mobile layout only
    //remove event listeners
		sidebar.element.removeEventListener('keydown', handleEvent.bind(sidebar));
		sidebar.element.removeEventListener('click', handleEvent.bind(sidebar));
  };

  function handleEvent(event) { // mobile layout only
    switch(event.type) {
      case 'click': {
        initClick(this, event);
      }
      case 'keydown': {
        initKeyDown(this, event);
      }
    }
  };

  function initKeyDown(sidebar, event) { // mobile layout only
    if( event.keyCode && event.keyCode == 27 || event.key && event.key == 'Escape' ) {
      //close sidebar window on esc
      closeSidebar(sidebar);
    } else if( event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' ) {
      //trap focus inside sidebar
      trapFocus(sidebar, event);
    }
  };

  function initClick(sidebar, event) { // mobile layout only
    //close sidebar when clicking on close button or sidebar bg layer 
		if( !event.target.closest('.js-sidebar__close-btn') && !Util.hasClass(event.target, 'js-sidebar') ) return;
		event.preventDefault();
		closeSidebar(sidebar);
  };

  function trapFocus(sidebar, event) { // mobile layout only
    if( sidebar.firstFocusable == document.activeElement && event.shiftKey) {
			//on Shift+Tab -> focus last focusable element when focus moves out of sidebar
			event.preventDefault();
			sidebar.lastFocusable.focus();
		}
		if( sidebar.lastFocusable == document.activeElement && !event.shiftKey) {
			//on Tab -> focus first focusable element when focus moves out of sidebar
			event.preventDefault();
			sidebar.firstFocusable.focus();
		}
  };

  function initSidebarResize(sidebar) {
    // custom event emitted when window is resized - detect only if the sidebar--static@{breakpoint} class was added
    var beforeContent = getComputedStyle(sidebar.element, ':before').getPropertyValue('content');
    if(beforeContent && beforeContent !='' && beforeContent !='none') {
      checkSidebarLayout(sidebar);

      sidebar.element.addEventListener('update-sidebar', function(event){
        checkSidebarLayout(sidebar);
      });
    } 
    // check if there a main element to show
    var mainContent = document.getElementsByClassName(sidebar.contentReadyClass);
    if(mainContent.length > 0) Util.removeClass(mainContent[0], sidebar.contentReadyClass);
    Util.addClass(sidebar.element, sidebar.readyClass);
  };

  function checkSidebarLayout(sidebar) {
    var layout = getComputedStyle(sidebar.element, ':before').getPropertyValue('content').replace(/\'|"/g, '');
    if(layout == sidebar.layout) return;
    sidebar.layout = layout;
    if(layout != 'static') Util.addClass(sidebar.element, 'is-hidden');
    Util.toggleClass(sidebar.element, sidebar.staticClass + sidebar.customStaticClass, layout == 'static');
    if(layout != 'static') setTimeout(function(){Util.removeClass(sidebar.element, 'is-hidden')});
    // reset element role 
    (layout == 'static') ? sidebar.element.removeAttribute('role', 'alertdialog') :  sidebar.element.setAttribute('role', 'alertdialog');
    // reset mobile behaviour
    if(layout == 'static' && Util.hasClass(sidebar.element, sidebar.showClass)) closeSidebar(sidebar);
  };

  function getFocusableElements(sidebar) {
    //get all focusable elements inside the drawer
		var allFocusable = sidebar.element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary');
		getFirstVisible(sidebar, allFocusable);
		getLastVisible(sidebar, allFocusable);
  };

  function getFirstVisible(sidebar, elements) {
		//get first visible focusable element inside the sidebar
		for(var i = 0; i < elements.length; i++) {
			if( elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length ) {
				sidebar.firstFocusable = elements[i];
				return true;
			}
		}
	};

	function getLastVisible(sidebar, elements) {
		//get last visible focusable element inside the sidebar
		for(var i = elements.length - 1; i >= 0; i--) {
			if( elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length ) {
				sidebar.lastFocusable = elements[i];
				return true;
			}
		}
  };

  //initialize the Sidebar objects
	var sidebar = document.getElementsByClassName('js-sidebar');
	if( sidebar.length > 0 ) {
		for( var i = 0; i < sidebar.length; i++) {
			(function(i){new Sidebar(sidebar[i]);})(i);
    }
    // switch from mobile to static layout
    var customEvent = new CustomEvent('update-sidebar');
    window.addEventListener('resize', function(event){
      (!window.requestAnimationFrame) ? setTimeout(function(){resetLayout();}, 250) : window.requestAnimationFrame(resetLayout);
    });

    (window.requestAnimationFrame) // init sidebar layout
      ? window.requestAnimationFrame(resetLayout)
      : resetLayout();

    function resetLayout() {
      for( var i = 0; i < sidebar.length; i++) {
        (function(i){sidebar[i].dispatchEvent(customEvent)})(i);
      };
    };
	}
}());
// File#: _1_row-table
// Usage: codyhouse.co/license
(function() {
    var RowTable = function(element) {
        this.element = element;
        this.headerRows = this.element.getElementsByTagName('thead')[0].getElementsByTagName('th');
        this.tableRows = this.element.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        this.collapsedLayoutClass = 'row-table--collapsed';
        this.mainRowCellClass = 'row-table__th-inner';
        initTable(this);
    };

    function initTable(table) {
        checkTableLayour(table); // switch from a collapsed to an expanded layout

        // create additional table content
        addTableContent(table);

        // custom event emitted when window is resized
        table.element.addEventListener('update-row-table', function(event){
            checkTableLayour(table);
        });

        // mobile version - listent to click/key enter on the row -> expand it
        table.element.addEventListener('click', function(event){
            revealRowDetails(table, event);
        });
        table.element.addEventListener('keydown', function(event){
            if(event.keyCode && event.keyCode == 13 || event.key && event.key.toLowerCase() == 'enter') {
                revealRowDetails(table, event);
            }
        });
    };

    function checkTableLayour(table) {
        var layout = getComputedStyle(table.element, ':before').getPropertyValue('content').replace(/\'|"/g, '');
        Util.toggleClass(table.element, table.collapsedLayoutClass, layout == 'expanded');
    };

    function addTableContent(table) {
        // for the expanded version, add a ul with list of details for each table row
        for(var i = 0; i < table.tableRows.length; i++) {
            var content = '';
            var cells = table.tableRows[i].getElementsByClassName('row-table__cell');
            for(var j = 0; j < cells.length; j++) {
                if(j == 0 ) {
                    Util.addClass(cells[j], 'js-'+table.mainRowCellClass);
                    var cellLabel = cells[j].getElementsByClassName('row-table__th-inner');
                    if(cellLabel.length > 0 ) cellLabel[0].innerHTML = cellLabel[0].innerHTML + '<i class="row-table__th-icon" aria-hidden="true"></i>'
                } else {
                    content = content + '<li class="row-table__item"><span class="row-table__label">'+table.headerRows[j].innerHTML+':</span><span>'+cells[j].innerHTML+'</span></li>';
                }
            }
            content = '<ul class="row-table__list" aria-hidden="true">'+content+'</ul>';
            cells[0].innerHTML = '<input type="text" class="row-table__input" aria-hidden="true">'+cells[0].innerHTML + content;
        }
    };

    function revealRowDetails(table, event) {
        if(!event.target.closest('.js-'+table.mainRowCellClass) || event.target.closest('.row-table__list')) return;
        var row = event.target.closest('.js-'+table.mainRowCellClass);
        Util.toggleClass(row, 'row-table__cell--show-list', !Util.hasClass(row, 'row-table__cell--show-list'));
    };

    //initialize the RowTable objects
    var rowTables = document.getElementsByClassName('js-row-table');
    if( rowTables.length > 0 ) {
        var j = 0,
            rowTablesArray = [];
        for( var i = 0; i < rowTables.length; i++) {
            var beforeContent = getComputedStyle(rowTables[i], ':before').getPropertyValue('content');
            if(beforeContent && beforeContent !='' && beforeContent !='none') {
                (function(i){rowTablesArray.push(new RowTable(rowTables[i]));})(i);
                j = j + 1;
            }
        }

        if(j > 0) {
            var resizingId = false,
                customEvent = new CustomEvent('update-row-table');
            window.addEventListener('resize', function(event){
                clearTimeout(resizingId);
                resizingId = setTimeout(doneResizing, 300);
            });

            function doneResizing() {
                for( var i = 0; i < rowTablesArray.length; i++) {
                    (function(i){rowTablesArray[i].element.dispatchEvent(customEvent)})(i);
                };
            };

            (window.requestAnimationFrame) // init table layout
                ? window.requestAnimationFrame(doneResizing)
                : doneResizing();
        }
    }
}());
(function() {
  var searchInput = document.getElementById('main-search-input');
  if(!searchInput) return;
  // focus on search using '/' shortcut
  window.addEventListener('keydown', function(event){
    if( event.key && event.key.toLowerCase() == '/' ) {
      event.preventDefault();
      searchInput.focus();
    }
  });
}());
// File#: _1_slider
// Usage: codyhouse.co/license
(function() {
  var Slider = function(element) {
    this.element = element;
    this.rangeWrapper = this.element.getElementsByClassName('slider__range');
    this.rangeInput = this.element.getElementsByClassName('slider__input');
    this.value = this.element.getElementsByClassName('js-slider__value');
    this.floatingValue = this.element.getElementsByClassName('js-slider__value--floating');
    this.rangeMin = this.rangeInput[0].getAttribute('min');
    this.rangeMax = this.rangeInput[0].getAttribute('max');
    this.sliderWidth = window.getComputedStyle(this.element.getElementsByClassName('slider__range')[0]).getPropertyValue('width');
    this.thumbWidth = getComputedStyle(this.element).getPropertyValue('--slide-thumb-size');
    this.isInputVar = (this.value[0].tagName.toLowerCase() == 'input');
    this.isFloatingVar = this.floatingValue.length > 0;
    if(this.isFloatingVar) {
      this.floatingValueLeft = window.getComputedStyle(this.floatingValue[0]).getPropertyValue('left');
    }
    initSlider(this);
  };

  function initSlider(slider) {
    updateLabelValues(slider);// update label/input value so that it is the same as the input range
    updateLabelPosition(slider, false); // update label position if floating variation
    updateRangeColor(slider, false); // update range bg color
    checkRangeSupported(slider); // hide label/input value if input range is not supported

    // listen to change in the input range
    for(var i = 0; i < slider.rangeInput.length; i++) {
      (function(i){
        slider.rangeInput[i].addEventListener('input', function(event){
          updateSlider(slider, i);
        });
        slider.rangeInput[i].addEventListener('change', function(event){ // fix issue on IE where input event is not emitted
          updateSlider(slider, i);
        });
      })(i);
    }

    // if there's an input text, listen for changes in value, validate it and then update slider
    if(slider.isInputVar) {
      for(var i = 0; i < slider.value.length; i++) {
        (function(i){
          slider.value[i].addEventListener('change', function(event){
            updateRange(slider, i);
          });
        })(i);
      }
    }

    // native <input> element has been updated (e.g., form reset) -> update custom appearance
    slider.element.addEventListener('slider-updated', function(event){
      for(var i = 0; i < slider.value.length; i++) {updateSlider(slider, i);}
    });

    // custom events - emitted if slider has allows for multi-values
    slider.element.addEventListener('inputRangeLimit', function(event){
      updateLabelValues(slider);
      updateLabelPosition(slider, event.detail);
    });
  };

  function updateSlider(slider, index) {
    updateLabelValues(slider);
    updateLabelPosition(slider, index);
    updateRangeColor(slider, index);
  };

  function updateLabelValues(slider) {
    for(var i = 0; i < slider.rangeInput.length; i++) {
      slider.isInputVar ? slider.value[i].value = slider.rangeInput[i].value : slider.value[i].textContent = slider.rangeInput[i].value;
    }
  };

  function updateLabelPosition(slider, index) {
    if(!slider.isFloatingVar) return;
    var i = index ? index : 0,
      j = index ? index + 1: slider.rangeInput.length;
    for(var k = i; k < j; k++) {
      var percentage = (slider.rangeInput[k].value - slider.rangeMin)/(slider.rangeMax - slider.rangeMin);
      slider.floatingValue[k].style.left = 'calc(0.5 * '+slider.floatingValueLeft+' + '+percentage+' * ( '+slider.sliderWidth+' - '+slider.floatingValueLeft+' ))';
    }
  };

  function updateRangeColor(slider, index) {
    if(slider.rangeInput.length > 1) {slider.element.dispatchEvent(new CustomEvent('updateRange', {detail: index}));return;}
    var percentage = parseInt((slider.rangeInput[0].value - slider.rangeMin)/(slider.rangeMax - slider.rangeMin)*100),
      fill = 'calc('+percentage+'*('+slider.sliderWidth+' - 0.5*'+slider.thumbWidth+')/100)',
      empty = 'calc('+slider.sliderWidth+' - '+percentage+'*('+slider.sliderWidth+' - 0.5*'+slider.thumbWidth+')/100)';

    slider.rangeWrapper[0].style.setProperty('--slider-fill-value', fill);
    slider.rangeWrapper[0].style.setProperty('--slider-empty-value', empty);
  };

  function updateRange(slider, index) {
    var newValue = parseFloat(slider.value[index].value);
    if(isNaN(newValue)) {
      slider.value[index].value = slider.rangeInput[index].value;
      return;
    } else {
      if(newValue < slider.rangeMin) newValue = slider.rangeMin;
      if(newValue > slider.rangeMax) newValue = slider.rangeMax;
      slider.rangeInput[index].value = newValue;
      var inputEvent = new Event('change');
      slider.rangeInput[index].dispatchEvent(inputEvent);
    }
  };

  function checkRangeSupported(slider) {
    var input = document.createElement("input");
    input.setAttribute("type", "range");
    Util.toggleClass(slider.element, 'slider--range-not-supported', input.type !== "range");
  };

  //initialize the Slider objects
  var sliders = document.getElementsByClassName('js-slider');
  if( sliders.length > 0 ) {
    for( var i = 0; i < sliders.length; i++) {
      (function(i){new Slider(sliders[i]);})(i);
    }
  }
}());
// File#: _1_smooth-scrolling
// Usage: codyhouse.co/license
(function() {
	var SmoothScroll = function(element) {
		if(!('CSS' in window) || !CSS.supports('color', 'var(--color-var)')) return;
		this.element = element;
		this.scrollDuration = parseInt(this.element.getAttribute('data-duration')) || 300;
		this.dataElementY = this.element.getAttribute('data-scrollable-element-y') || this.element.getAttribute('data-scrollable-element') || this.element.getAttribute('data-element');
		this.scrollElementY = this.dataElementY ? document.querySelector(this.dataElementY) : window;
		this.dataElementX = this.element.getAttribute('data-scrollable-element-x');
		this.scrollElementX = this.dataElementY ? document.querySelector(this.dataElementX) : window;
		this.scrollPaddingEl = document.querySelector('.js-side-template-v3__main');
		this.initScroll();
	};

	SmoothScroll.prototype.initScroll = function() {
		var self = this;

		//detect click on link
		this.element.addEventListener('click', function(event){
			event.preventDefault();
			var targetId = event.target.closest('.js-smooth-scroll').getAttribute('href').replace('#', ''),
				target = document.getElementById(targetId),
				targetTabIndex = target.getAttribute('tabindex'),
				windowScrollTop = self.scrollElementY.scrollTop || document.documentElement.scrollTop;

			// scroll vertically
			if(!self.dataElementY) windowScrollTop = window.scrollY || document.documentElement.scrollTop;

			var scrollElementY = self.dataElementY ? self.scrollElementY : false;

			var fixedHeight = self.getFixedElementHeight(); // check if there's a fixed element on the page
			Util.scrollTo(target.getBoundingClientRect().top + windowScrollTop - fixedHeight, self.scrollDuration, function() {
				// scroll horizontally
				self.scrollHorizontally(target, fixedHeight);
				//move the focus to the target element - don't break keyboard navigation
				Util.moveFocus(target);
				history.pushState(false, false, '#'+targetId);
				self.resetTarget(target, targetTabIndex);
			}, scrollElementY);
		});
	};

	SmoothScroll.prototype.scrollHorizontally = function(target, delta) {
    var scrollEl = this.dataElementX ? this.scrollElementX : false;
    var windowScrollLeft = this.scrollElementX ? this.scrollElementX.scrollLeft : document.documentElement.scrollLeft;
    var final = target.getBoundingClientRect().left + windowScrollLeft - delta,
      duration = this.scrollDuration;

    var element = scrollEl || window;
    var start = element.scrollLeft || document.documentElement.scrollLeft,
      currentTime = null;

    if(!scrollEl) start = window.scrollX || document.documentElement.scrollLeft;
		// return if there's no need to scroll
    if(Math.abs(start - final) < 5) return;
        
    var animateScroll = function(timestamp){
      if (!currentTime) currentTime = timestamp;        
      var progress = timestamp - currentTime;
      if(progress > duration) progress = duration;
      var val = Math.easeInOutQuad(progress, start, final-start, duration);
      element.scrollTo({
				left: val,
			});
      if(progress < duration) {
        window.requestAnimationFrame(animateScroll);
      }
    };

    window.requestAnimationFrame(animateScroll);
  };

	SmoothScroll.prototype.resetTarget = function(target, tabindex) {
		if( parseInt(target.getAttribute('tabindex')) < 0) {
			// target.style.outline = 'none';
			!tabindex && target.removeAttribute('tabindex');
			// highlight section on target
			Util.addClass(target, 'toc-content__target--selected');
			target.addEventListener('animationend', function cb(event){
				event.stopPropagation();
				target.removeEventListener('animationend', cb);
				Util.removeClass(target, 'toc-content__target--selected');
			});
		}	
	};

	SmoothScroll.prototype.getFixedElementHeight = function() {
    var fixedElementDelta = parseInt(getComputedStyle(this.scrollPaddingEl).getPropertyValue('scroll-padding'));
		if(isNaN(fixedElementDelta) ) { // scroll-padding not supported
			fixedElementDelta = 0;
			var fixedElement = document.querySelector(this.element.getAttribute('data-fixed-element'));
			if(fixedElement) fixedElementDelta = parseInt(fixedElement.getBoundingClientRect().height);
		}
		return fixedElementDelta;
	};
	
	//initialize the Smooth Scroll objects
	var smoothScrollLinks = document.getElementsByClassName('js-smooth-scroll');
	if( smoothScrollLinks.length > 0 && window.requestAnimationFrame) {
		// you need javascript only if css scroll-behavior is not supported
		for( var i = 0; i < smoothScrollLinks.length; i++) {
			(function(i){new SmoothScroll(smoothScrollLinks[i]);})(i);
		}
	}
}());
// File#: _1_tabs
// Usage: codyhouse.co/license
(function() {
  var Tab = function(element) {
    this.element = element;
    this.tabList = this.element.getElementsByClassName('js-tabs__controls')[0];
    this.listItems = this.tabList.getElementsByTagName('li');
    this.triggers = this.tabList.getElementsByTagName('a');
    this.panelsList = this.element.getElementsByClassName('js-tabs__panels')[0];
    this.panels = Util.getChildrenByClassName(this.panelsList, 'js-tabs__panel');
    this.hideClass = 'is-hidden';
    this.customShowClass = this.element.getAttribute('data-show-panel-class') ? this.element.getAttribute('data-show-panel-class') : false;
    this.layout = this.element.getAttribute('data-tabs-layout') ? this.element.getAttribute('data-tabs-layout') : 'horizontal';
    // deep linking options
    this.deepLinkOn = this.element.getAttribute('data-deep-link') == 'on';
    // init tabs
    this.initTab();
  };

  Tab.prototype.initTab = function() {
    //set initial aria attributes
    this.tabList.setAttribute('role', 'tablist');
    for( var i = 0; i < this.triggers.length; i++) {
      var bool = (i == 0),
        panelId = this.panels[i].getAttribute('id');
      this.listItems[i].setAttribute('role', 'presentation');
      Util.setAttributes(this.triggers[i], {'role': 'tab', 'aria-selected': bool, 'aria-controls': panelId, 'id': 'tab-'+panelId});
      Util.addClass(this.triggers[i], 'js-tabs__trigger');
      Util.setAttributes(this.panels[i], {'role': 'tabpanel', 'aria-labelledby': 'tab-'+panelId});
      Util.toggleClass(this.panels[i], this.hideClass, !bool);

      if(!bool) this.triggers[i].setAttribute('tabindex', '-1');
    }

    //listen for Tab events
    this.initTabEvents();

    // check deep linking option
    this.initDeepLink();
  };

  Tab.prototype.initTabEvents = function() {
    var self = this;
    //click on a new tab -> select content
    this.tabList.addEventListener('click', function(event) {
      if( event.target.closest('.js-tabs__trigger') ) self.triggerTab(event.target.closest('.js-tabs__trigger'), event);
    });
    //arrow keys to navigate through tabs
    this.tabList.addEventListener('keydown', function(event) {
      ;
      if( !event.target.closest('.js-tabs__trigger') ) return;
      if( tabNavigateNext(event, self.layout) ) {
        event.preventDefault();
        self.selectNewTab('next');
      } else if( tabNavigatePrev(event, self.layout) ) {
        event.preventDefault();
        self.selectNewTab('prev');
      }
    });
  };

  Tab.prototype.selectNewTab = function(direction) {
    var selectedTab = this.tabList.querySelector('[aria-selected="true"]'),
      index = Util.getIndexInArray(this.triggers, selectedTab);
    index = (direction == 'next') ? index + 1 : index - 1;
    //make sure index is in the correct interval
    //-> from last element go to first using the right arrow, from first element go to last using the left arrow
    if(index < 0) index = this.listItems.length - 1;
    if(index >= this.listItems.length) index = 0;
    this.triggerTab(this.triggers[index]);
    this.triggers[index].focus();
  };

  Tab.prototype.triggerTab = function(tabTrigger, event) {
    var self = this;
    event && event.preventDefault();
    var index = Util.getIndexInArray(this.triggers, tabTrigger);
    //no need to do anything if tab was already selected
    if(this.triggers[index].getAttribute('aria-selected') == 'true') return;

    for( var i = 0; i < this.triggers.length; i++) {
      var bool = (i == index);
      Util.toggleClass(this.panels[i], this.hideClass, !bool);
      if(this.customShowClass) Util.toggleClass(this.panels[i], this.customShowClass, bool);
      this.triggers[i].setAttribute('aria-selected', bool);
      bool ? this.triggers[i].setAttribute('tabindex', '0') : this.triggers[i].setAttribute('tabindex', '-1');
    }

    // update url if deepLink is on
    if(this.deepLinkOn) {
      history.replaceState(null, '', '#'+tabTrigger.getAttribute('aria-controls'));
    }
  };

  Tab.prototype.initDeepLink = function() {
    if(!this.deepLinkOn) return;
    var hash = window.location.hash.substr(1);
    var self = this;
    if(!hash || hash == '') return;
    for(var i = 0; i < this.panels.length; i++) {
      if(this.panels[i].getAttribute('id') == hash) {
        this.triggerTab(this.triggers[i], false);
        setTimeout(function(){self.panels[i].scrollIntoView(true);});
        break;
      }
    };
  };

  function tabNavigateNext(event, layout) {
    if(layout == 'horizontal' && (event.keyCode && event.keyCode == 39 || event.key && event.key == 'ArrowRight')) {return true;}
    else if(layout == 'vertical' && (event.keyCode && event.keyCode == 40 || event.key && event.key == 'ArrowDown')) {return true;}
    else {return false;}
  };

  function tabNavigatePrev(event, layout) {
    if(layout == 'horizontal' && (event.keyCode && event.keyCode == 37 || event.key && event.key == 'ArrowLeft')) {return true;}
    else if(layout == 'vertical' && (event.keyCode && event.keyCode == 38 || event.key && event.key == 'ArrowUp')) {return true;}
    else {return false;}
  };

  //initialize the Tab objects
  var tabs = document.getElementsByClassName('js-tabs');
  if( tabs.length > 0 ) {
    for( var i = 0; i < tabs.length; i++) {
      (function(i){new Tab(tabs[i]);})(i);
    }
  }
}());
(function() {
  var themeSwitch = document.getElementById('switch-light-dark');
  if(themeSwitch) {
    var htmlElement = document.getElementsByTagName("html")[0],
      darkInput = themeSwitch.querySelector('input[value="dark"]');
    initTheme();
    
    themeSwitch.addEventListener('change', function(event){
      resetTheme(event.target.value);
    });

    function initTheme() {
      if(htmlElement.getAttribute('data-theme') == 'dark') {
        darkInput.checked = true;
      }
    };

    function resetTheme(theme) {
      if(theme == 'dark') {
        htmlElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('themeSwitch', 'dark');
      } else {
        htmlElement.removeAttribute('data-theme');
        localStorage.setItem('themeSwitch', 'light');
      }
    };
  }
}());
// File#: _2_autocomplete
// Usage: codyhouse.co/license
(function() {
  var Autocomplete = function(opts) {
    if(!('CSS' in window) || !CSS.supports('color', 'var(--color-var)')) return;
    this.options = Util.extend(Autocomplete.defaults, opts);
    this.element = this.options.element;
    this.input = this.element.getElementsByClassName('js-autocomplete__input')[0];
    this.results = this.element.getElementsByClassName('js-autocomplete__results')[0];
    this.resultsList = this.results.getElementsByClassName('js-autocomplete__list')[0];
    this.ariaResult = this.element.getElementsByClassName('js-autocomplete__aria-results');
    this.resultClassName = this.element.getElementsByClassName('js-autocomplete__item').length > 0 ? 'js-autocomplete__item' : 'js-autocomplete__result';
    // store search info
    this.inputVal = '';
    this.typeId = false;
    this.searching = false;
    this.searchingClass = this.element.getAttribute('data-autocomplete-searching-class') || 'autocomplete--searching';
    // dropdown reveal class
    this.dropdownActiveClass =  this.element.getAttribute('data-autocomplete-dropdown-visible-class') || this.element.getAttribute('data-dropdown-active-class');
    // truncate dropdown
    this.truncateDropdown = this.element.getAttribute('data-autocomplete-dropdown-truncate') && this.element.getAttribute('data-autocomplete-dropdown-truncate') == 'on' ? true : false;
    initAutocomplete(this);
    this.autocompleteClosed = false; // fix issue when selecting an option from the list
  };

  function initAutocomplete(element) {
    initAutocompleteAria(element); // set aria attributes for SR and keyboard users
    initAutocompleteTemplates(element);
    initAutocompleteEvents(element);
  };

  function initAutocompleteAria(element) {
    // set aria attributes for input element
    Util.setAttributes(element.input, {'role': 'combobox', 'aria-autocomplete': 'list'});
    var listId = element.resultsList.getAttribute('id');
    if(listId) element.input.setAttribute('aria-owns', listId);
    // set aria attributes for autocomplete list
    element.resultsList.setAttribute('role', 'list');
  };

  function initAutocompleteTemplates(element) {
    element.templateItems = element.resultsList.querySelectorAll('.'+element.resultClassName+'[data-autocomplete-template]');
    if(element.templateItems.length < 1) element.templateItems = element.resultsList.querySelectorAll('.'+element.resultClassName);
    element.templates = [];
    for(var i = 0; i < element.templateItems.length; i++) {
      element.templates[i] = element.templateItems[i].getAttribute('data-autocomplete-template');
    }
  };

  function initAutocompleteEvents(element) {
    // input - keyboard navigation 
    element.input.addEventListener('keyup', function(event){
      handleInputTyped(element, event);
    });

    // if input type="search" -> detect when clicking on 'x' to clear input
    element.input.addEventListener('search', function(event){
      updateSearch(element);
    });

    // make sure dropdown is open on click
    element.input.addEventListener('click', function(event){
      updateSearch(element, true);
    });

    element.input.addEventListener('focus', function(event){
      if(element.autocompleteClosed) {
        element.autocompleteClosed = false;
        return;
      }
      updateSearch(element, true);
    });

    // input loses focus -> close menu
    element.input.addEventListener('blur', function(event){
      checkFocusLost(element, event);
    });

    // results list - keyboard navigation 
    element.resultsList.addEventListener('keydown', function(event){
      navigateList(element, event);
    });

    // results list loses focus -> close menu
    element.resultsList.addEventListener('focusout', function(event){
      checkFocusLost(element, event);
    });

    // close on esc
    window.addEventListener('keyup', function(event){
      if( event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape' ) {
        toggleOptionsList(element, false);
      } else if(event.keyCode && event.keyCode == 13 || event.key && event.key.toLowerCase() == 'enter') { // on Enter - select result if focus is within results list
        selectResult(element, document.activeElement.closest('.'+element.resultClassName), event);
      }
    });

    // select element from list
    element.resultsList.addEventListener('click', function(event){
      selectResult(element, event.target.closest('.'+element.resultClassName), event);
    });
  };

  function checkFocusLost(element, event) {
    if(element.element.contains(event.relatedTarget)) return;
    toggleOptionsList(element, false);
  };

  function handleInputTyped(element, event) {
    if(event.key.toLowerCase() == 'arrowdown' || event.keyCode == '40') {
      moveFocusToList(element);
    } else {
      updateSearch(element);
    }
  };

  function moveFocusToList(element) {
    console.log('test');
    if(!Util.hasClass(element.element, element.dropdownActiveClass)) return;
    resetSearch(element); // clearTimeout
    // make sure first element is focusable
    var index = 0;
    if(!elementListIsFocusable(element.resultsItems[index])) {
      index = getElementFocusbleIndex(element, index, true);
    }
    getListFocusableEl(element.resultsItems[index]).focus();
  };

  function updateSearch(element, bool) {
    var inputValue = element.input.value;
    if(inputValue == element.inputVal && !bool) return; // input value did not change
    element.inputVal = inputValue;
    if(element.typeId) clearInterval(element.typeId); // clearTimeout
    if(element.inputVal.length < element.options.characters) { // not enough characters to start searching
      toggleOptionsList(element, false);
      return;
    }
    if(bool) { // on focus -> update result list without waiting for the debounce
      updateResultsList(element, 'focus');
      return;
    }
    element.typeId = setTimeout(function(){
      updateResultsList(element, 'type');
    }, element.options.debounce);
  };

  function toggleOptionsList(element, bool) {
    // toggle visibility of options list
    if(bool) {
      if(Util.hasClass(element.element, element.dropdownActiveClass)) return;
      Util.addClass(element.element, element.dropdownActiveClass);
      element.input.setAttribute('aria-expanded', true);
      truncateAutocompleteList(element);
    } else {
      if(!Util.hasClass(element.element, element.dropdownActiveClass)) return;
      if(element.resultsList.contains(document.activeElement)) {
        element.autocompleteClosed = true;
        element.input.focus();
      }
      Util.removeClass(element.element, element.dropdownActiveClass);
      element.input.removeAttribute('aria-expanded');
      resetSearch(element); // clearTimeout
    }
  };

  function truncateAutocompleteList(element) {
    if(!element.truncateDropdown) return;
    // reset max height
    element.resultsList.style.maxHeight = '';
    // check available space 
    var spaceBelow = (window.innerHeight - element.input.getBoundingClientRect().bottom - 10),
      maxHeight = parseInt(getComputedStyle(element.resultsList).maxHeight);

    (maxHeight > spaceBelow) 
      ? element.resultsList.style.maxHeight = spaceBelow+'px' 
      : element.resultsList.style.maxHeight = '';
  };

  function updateResultsList(element, eventType) {
    if(element.searching) return;
    element.searching = true;
    Util.addClass(element.element, element.searchingClass); // show loader
    element.options.searchData(element.inputVal, function(data){
      // data = custom results
      populateResults(element, data);
      Util.removeClass(element.element, element.searchingClass);
      toggleOptionsList(element, true);
      updateAriaRegion(element);
      element.searching = false;
    }, eventType);
  };

  function updateAriaRegion(element) {
    element.resultsItems = element.resultsList.querySelectorAll('.'+element.resultClassName+'[tabindex="-1"]');
    if(element.ariaResult.length == 0) return;
    element.ariaResult[0].textContent = element.resultsItems.length;
  };

  function resetSearch(element) {
    if(element.typeId) clearInterval(element.typeId);
    element.typeId = false;
  };

  function navigateList(element, event) {
    var downArrow = (event.key.toLowerCase() == 'arrowdown' || event.keyCode == '40'),
      upArrow = (event.key.toLowerCase() == 'arrowup' || event.keyCode == '38');
    if(!downArrow && !upArrow) return;
    event.preventDefault();
    var selectedElement = document.activeElement.closest('.'+element.resultClassName) || document.activeElement;
    var index = Util.getIndexInArray(element.resultsItems, selectedElement);
    var newIndex = getElementFocusbleIndex(element, index, downArrow);
    getListFocusableEl(element.resultsItems[newIndex]).focus();
  };

  function getElementFocusbleIndex(element, index, nextItem) {
    var newIndex = nextItem ? index + 1 : index - 1;
    if(newIndex < 0) newIndex = element.resultsItems.length - 1;
    if(newIndex >= element.resultsItems.length) newIndex = 0;
    // check if element can be focused
    if(!elementListIsFocusable(element.resultsItems[newIndex])) {
      // skip this element
      return getElementFocusbleIndex(element, newIndex, nextItem);
    }
    return newIndex;
  };

  function elementListIsFocusable(item) {
    var role = item.getAttribute('role');
    if(role && role == 'presentation') {
      // skip this element
      return false;
    }
    return true;
  };

  function getListFocusableEl(item) {
    var newFocus = item,
      focusable = newFocus.querySelectorAll('button:not([disabled]), [href]');
    if(focusable.length > 0 ) newFocus = focusable[0];
    return newFocus;
  };

  function selectResult(element, result, event) {
    if(!result) return;
    if(element.options.onClick) {
      element.options.onClick(result, element, event, function(){
        toggleOptionsList(element, false);
      });
    } else {
      element.input.value = getResultContent(result);
      toggleOptionsList(element, false);
    }
    element.inputVal = element.input.value;
  };

  function getResultContent(result) { // get text content of selected item
    var labelElement = result.querySelector('[data-autocomplete-label]');
    return labelElement ? labelElement.textContent : result.textContent;
  };

  function populateResults(element, data) {
    var innerHtml = '';

    for(var i = 0; i < data.length; i++) {
      innerHtml = innerHtml + getItemHtml(element, data[i]);
    }
    element.resultsList.innerHTML = innerHtml;
  };

  function getItemHtml(element, data) {
    var clone = getClone(element, data);
    Util.removeClass(clone, 'is-hidden');
    clone.setAttribute('tabindex', '-1');
    for(var key in data) {
      if (data.hasOwnProperty(key)) {
        if(key == 'label') setLabel(clone, data[key]);
        else if(key == 'class') setClass(clone, data[key]);
        else if(key == 'url') setUrl(clone, data[key]);
        else if(key == 'src') setSrc(clone, data[key]);
        else setKey(clone, key, data[key]);
      }
    }
    return clone.outerHTML;
  };

  function getClone(element, data) {
    var item = false;
    if(element.templateItems.length == 1 || !data['template']) item = element.templateItems[0];
    else {
      for(var i = 0; i < element.templateItems.length; i++) {
        if(data['template'] == element.templates[i]) {
          item = element.templateItems[i];
        }
      }
      if(!item) item = element.templateItems[0];
    }
    return item.cloneNode(true);
  };

  function setLabel(clone, label) {
    var labelElement = clone.querySelector('[data-autocomplete-label]');
    labelElement 
      ? labelElement.textContent = label
      : clone.textContent = label;
  };

  function setClass(clone, classList) {
    Util.addClass(clone, classList);
  };

  function setUrl(clone, url) {
    var linkElement = clone.querySelector('[data-autocomplete-url]');
    if(linkElement) linkElement.setAttribute('href', url);
  };

  function setSrc(clone, src) {
    var imgElement = clone.querySelector('[data-autocomplete-src]');
    if(imgElement) imgElement.setAttribute('src', src);
  };

  function setKey(clone, key, value) {
    var subElement = clone.querySelector('[data-autocomplete-'+key+']');
    if(subElement) {
      if(subElement.hasAttribute('data-autocomplete-html')) subElement.innerHTML = value;
      else subElement.textContent = value;
    }
  };

  Autocomplete.defaults = {
    element : '',
    debounce: 200,
    characters: 2,
    searchData: false, // function used to return results
    onClick: false // function executed when selecting an item in the list; arguments (result, obj) -> selected <li> item + Autocompletr obj reference
  };

  window.Autocomplete = Autocomplete;
}());
// File#: _2_comments
// Usage: codyhouse.co/license
(function() {
  function initVote(element) {
    var voteCounter = element.getElementsByClassName('js-comments__vote-label');
    element.addEventListener('click', function(){
      var pressed = element.getAttribute('aria-pressed') == 'true';
      element.setAttribute('aria-pressed', !pressed);
      Util.toggleClass(element, 'comments__vote-btn--pressed', !pressed);
      resetCounter(voteCounter, pressed);
      emitKeypressEvents(element, voteCounter, pressed);
    });
  };

  function resetCounter(voteCounter, pressed) { // update counter value (if present)
    if(voteCounter.length == 0) return;
    var count = parseInt(voteCounter[0].textContent);
    voteCounter[0].textContent = pressed ? count - 1 : count + 1;
  };

  function emitKeypressEvents(element, label, pressed) { // emit custom event when vote is updated
    var count = (label.length == 0) ? false : parseInt(label[0].textContent);
    var event = new CustomEvent('newVote', {detail: {count: count, upVote: !pressed}});
    element.dispatchEvent(event);
  };

  var voteCounting = document.getElementsByClassName('js-comments__vote-btn');
  if( voteCounting.length > 0 ) {
    for( var i = 0; i < voteCounting.length; i++) {
      (function(i){initVote(voteCounting[i]);})(i);
    }
  }
}());
// File#: _2_content-rating
// Usage: codyhouse.co/license
(function() {
  function initRateCont(element) {
    var commentSection = element.getElementsByClassName('js-rate-cont__comment');
    if(commentSection.length == 0) return;
    element.addEventListener('change', function() {
      // show comment input if user selects one of the radio btns
      showComment(commentSection[0]);
    });
  };

  function showComment(comment) {
    if(!Util.hasClass(comment, 'is-hidden')) return;
    // reveal comment section
    Util.removeClass(comment, 'is-hidden');
    var initHeight = 0,
			finalHeight = comment.offsetHeight;
    if(window.requestAnimationFrame && !reducedMotion) {
      Util.setHeight(initHeight, finalHeight, comment, 200, function(){
        // move focus to textarea
        var textArea = comment.querySelector('textarea');
        if(textArea) textArea.focus();
        // remove inline style
        comment.style.height = '';
      }, 'easeInOutQuad');
    }
  };

  var rateCont = document.getElementsByClassName('js-rate-cont'),
    reducedMotion = Util.osHasReducedMotion();
  if( rateCont.length > 0 ) {
		for( var i = 0; i < rateCont.length; i++) {
			(function(i){initRateCont(rateCont[i]);})(i);
		}
	}
}());
// File#: _2_dropdown
// Usage: codyhouse.co/license
(function() {
  var Dropdown = function(element) {
    this.element = element;
    this.trigger = this.element.getElementsByClassName('js-dropdown__trigger')[0];
    this.dropdown = this.element.getElementsByClassName('js-dropdown__menu')[0];
    this.triggerFocus = false;
    this.dropdownFocus = false;
    this.hideInterval = false;
    // sublevels
    this.dropdownSubElements = this.element.getElementsByClassName('js-dropdown__sub-wrapper');
    this.prevFocus = false; // store element that was in focus before focus changed
    this.addDropdownEvents();
  };

  Dropdown.prototype.addDropdownEvents = function(){
    //place dropdown
    var self = this;
    this.placeElement();
    this.element.addEventListener('placeDropdown', function(event){
      self.placeElement();
    });
    // init dropdown
    this.initElementEvents(this.trigger, this.triggerFocus); // this is used to trigger the primary dropdown
    this.initElementEvents(this.dropdown, this.dropdownFocus); // this is used to trigger the primary dropdown
    // init sublevels
    this.initSublevels(); // if there are additional sublevels -> bind hover/focus events
  };

  Dropdown.prototype.placeElement = function() {
    // remove inline style first
    this.dropdown.removeAttribute('style');
    // check dropdown position
    var triggerPosition = this.trigger.getBoundingClientRect(),
      isRight = (window.innerWidth < triggerPosition.left + parseInt(getComputedStyle(this.dropdown).getPropertyValue('width')));

    var xPosition = isRight ? 'right: 0px; left: auto;' : 'left: 0px; right: auto;';
    this.dropdown.setAttribute('style', xPosition);
  };

  Dropdown.prototype.initElementEvents = function(element, bool) {
    var self = this;
    element.addEventListener('mouseenter', function(){
      bool = true;
      self.showDropdown();
    });
    element.addEventListener('focus', function(){
      self.showDropdown();
    });
    element.addEventListener('mouseleave', function(){
      bool = false;
      self.hideDropdown();
    });
    element.addEventListener('focusout', function(){
      self.hideDropdown();
    });
  };

  Dropdown.prototype.showDropdown = function(){
    if(this.hideInterval) clearInterval(this.hideInterval);
    // remove style attribute
    this.dropdown.removeAttribute('style');
    this.placeElement();
    this.showLevel(this.dropdown, true);
  };

  Dropdown.prototype.hideDropdown = function(){
    var self = this;
    if(this.hideInterval) clearInterval(this.hideInterval);
    this.hideInterval = setTimeout(function(){
      var dropDownFocus = document.activeElement.closest('.js-dropdown'),
        inFocus = dropDownFocus && (dropDownFocus == self.element);
      // if not in focus and not hover -> hide
      if(!self.triggerFocus && !self.dropdownFocus && !inFocus) {
        self.hideLevel(self.dropdown, true);
        // make sure to hide sub/dropdown
        self.hideSubLevels();
        self.prevFocus = false;
      }
    }, 300);
  };

  Dropdown.prototype.initSublevels = function(){
    var self = this;
    var dropdownMenu = this.element.getElementsByClassName('js-dropdown__menu');
    for(var i = 0; i < dropdownMenu.length; i++) {
      var listItems = dropdownMenu[i].children;
      // bind hover
      new menuAim({
        menu: dropdownMenu[i],
        activate: function(row) {
        	var subList = row.getElementsByClassName('js-dropdown__menu')[0];
        	if(!subList) return;
        	Util.addClass(row.querySelector('a'), 'dropdown__item--hover');
        	self.showLevel(subList);
        },
        deactivate: function(row) {
        	var subList = row.getElementsByClassName('dropdown__menu')[0];
        	if(!subList) return;
        	Util.removeClass(row.querySelector('a'), 'dropdown__item--hover');
        	self.hideLevel(subList);
        },
        submenuSelector: '.js-dropdown__sub-wrapper',
      });
    }
    // store focus element before change in focus
    this.element.addEventListener('keydown', function(event) {
      if( event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' ) {
        self.prevFocus = document.activeElement;
      }
    });
    // make sure that sublevel are visible when their items are in focus
    this.element.addEventListener('keyup', function(event) {
      if( event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' ) {
        // focus has been moved -> make sure the proper classes are added to subnavigation
        var focusElement = document.activeElement,
          focusElementParent = focusElement.closest('.js-dropdown__menu'),
          focusElementSibling = focusElement.nextElementSibling;

        // if item in focus is inside submenu -> make sure it is visible
        if(focusElementParent && !Util.hasClass(focusElementParent, 'dropdown__menu--is-visible')) {
          self.showLevel(focusElementParent);
        }
        // if item in focus triggers a submenu -> make sure it is visible
        if(focusElementSibling && !Util.hasClass(focusElementSibling, 'dropdown__menu--is-visible')) {
          self.showLevel(focusElementSibling);
        }

        // check previous element in focus -> hide sublevel if required
        if( !self.prevFocus) return;
        var prevFocusElementParent = self.prevFocus.closest('.js-dropdown__menu'),
          prevFocusElementSibling = self.prevFocus.nextElementSibling;

        if( !prevFocusElementParent ) return;

        // element in focus and element prev in focus are siblings
        if( focusElementParent && focusElementParent == prevFocusElementParent) {
          if(prevFocusElementSibling) self.hideLevel(prevFocusElementSibling);
          return;
        }

        // element in focus is inside submenu triggered by element prev in focus
        if( prevFocusElementSibling && focusElementParent && focusElementParent == prevFocusElementSibling) return;

        // shift tab -> element in focus triggers the submenu of the element prev in focus
        if( focusElementSibling && prevFocusElementParent && focusElementSibling == prevFocusElementParent) return;

        var focusElementParentParent = focusElementParent.parentNode.closest('.js-dropdown__menu');

        // shift tab -> element in focus is inside the dropdown triggered by a siblings of the element prev in focus
        if(focusElementParentParent && focusElementParentParent == prevFocusElementParent) {
          if(prevFocusElementSibling) self.hideLevel(prevFocusElementSibling);
          return;
        }

        if(prevFocusElementParent && Util.hasClass(prevFocusElementParent, 'dropdown__menu--is-visible')) {
          self.hideLevel(prevFocusElementParent);
        }
      }
    });
  };

  Dropdown.prototype.hideSubLevels = function(){
    var visibleSubLevels = this.dropdown.getElementsByClassName('dropdown__menu--is-visible');
    if(visibleSubLevels.length == 0) return;
    while (visibleSubLevels[0]) {
      this.hideLevel(visibleSubLevels[0]);
   	}
   	var hoveredItems = this.dropdown.getElementsByClassName('dropdown__item--hover');
   	while (hoveredItems[0]) {
      Util.removeClass(hoveredItems[0], 'dropdown__item--hover');
   	}
  };

  Dropdown.prototype.showLevel = function(level, bool){
    if(bool == undefined) {
      //check if the sublevel needs to be open to the left
      Util.removeClass(level, 'dropdown__menu--left');
      var boundingRect = level.getBoundingClientRect();
      if(window.innerWidth - boundingRect.right < 5 && boundingRect.left + window.scrollX > 2*boundingRect.width) Util.addClass(level, 'dropdown__menu--left');
    }
    Util.addClass(level, 'dropdown__menu--is-visible');
    Util.removeClass(level, 'dropdown__menu--is-hidden');
  };

  Dropdown.prototype.hideLevel = function(level, bool){
    if(!Util.hasClass(level, 'dropdown__menu--is-visible')) return;
    Util.removeClass(level, 'dropdown__menu--is-visible');
    Util.addClass(level, 'dropdown__menu--is-hidden');

    level.addEventListener('transitionend', function cb(event){
      if(event.propertyName != 'opacity') return;
      level.removeEventListener('transitionend', cb);
      Util.removeClass(level, 'dropdown__menu--is-hidden dropdown__menu--left');
      if(bool && !Util.hasClass(level, 'dropdown__menu--is-visible')) level.setAttribute('style', 'width: 0px');
    });
  };

  window.Dropdown = Dropdown;

  var dropdown = document.getElementsByClassName('js-dropdown');
  if( dropdown.length > 0 ) { // init Dropdown objects
    for( var i = 0; i < dropdown.length; i++) {
      (function(i){new Dropdown(dropdown[i]);})(i);
    }
  }
}());
// File#: _2_modal-video
// Usage: codyhouse.co/license
(function() {
	var ModalVideo = function(element) {
		this.element = element;
		this.modalContent = this.element.getElementsByClassName('js-modal-video__content')[0];
		this.media = this.element.getElementsByClassName('js-modal-video__media')[0];
		this.contentIsIframe = this.media.tagName.toLowerCase() == 'iframe';
		this.modalIsOpen = false;
		this.initModalVideo();
	};

	ModalVideo.prototype.initModalVideo = function() {
		var self = this;
		// reveal modal content when iframe is ready
		this.addLoadListener();
		// listen for the modal element to be open -> set new iframe src attribute
		this.element.addEventListener('modalIsOpen', function(event){
			self.modalIsOpen = true;
			self.media.setAttribute('src', event.detail.closest('[aria-controls]').getAttribute('data-url'));
		});
		// listen for the modal element to be close -> reset iframe and hide modal content
		this.element.addEventListener('modalIsClose', function(event){
			self.modalIsOpen = false;
			Util.addClass(self.element, 'modal--is-loading');
			self.media.setAttribute('src', '');
		});
	};

	ModalVideo.prototype.addLoadListener = function() {
		var self = this;
		if(this.contentIsIframe) {
			this.media.onload = function () {
				self.revealContent();
			};
		} else {
			this.media.addEventListener('loadedmetadata', function(){
				self.revealContent();
			});
		}
		
	};

	ModalVideo.prototype.revealContent = function() {
		if( !this.modalIsOpen ) return;
		Util.removeClass(this.element, 'modal--is-loading');
		this.contentIsIframe ? this.media.contentWindow.focus() : this.media.focus();
	};

	//initialize the ModalVideo objects
	var modalVideos = document.getElementsByClassName('js-modal-video__media');
	if( modalVideos.length > 0 ) {
		for( var i = 0; i < modalVideos.length; i++) {
			(function(i){new ModalVideo(modalVideos[i].closest('.js-modal'));})(i);
		}
	}
}());
// File#: _2_table-of-contents
// Usage: codyhouse.co/license
(function() {
  var Toc = function(element) {
		this.element = element;
    this.list = this.element.getElementsByClassName('js-toc__list')[0];
    this.anchors = this.list.querySelectorAll('a[href^="#"]');
    this.sections = getSections(this);
    this.controller = this.element.getElementsByClassName('js-toc__control');
    this.controllerLabel = this.element.getElementsByClassName('js-toc__control-label');
    this.content = getTocContent(this);
    this.clickScrolling = false;
    this.intervalID = false;
    this.staticLayoutClass = 'toc--static';
    this.contentStaticLayoutClass = 'toc-content--toc-static';
    this.expandedClass = 'toc--expanded';
    this.isStatic = Util.hasClass(this.element, this.staticLayoutClass);
    this.layout = 'static';
    initToc(this);
  };

  function getSections(toc) {
    var sections = [];
    // get all content sections
    for(var i = 0; i < toc.anchors.length; i++) {
      var section = document.getElementById(toc.anchors[i].getAttribute('href').replace('#', ''));
      if(section) sections.push(section);
    }
    return sections;
  };

  function getTocContent(toc) {
    if(toc.sections.length < 1) return false;
    var content = toc.sections[0].closest('.js-toc-content');
    return content;
  };

  function initToc(toc) {
    checkTocLayour(toc); // switch between mobile and desktop layout
    if(toc.sections.length > 0) {
      // listen for click on anchors
      toc.list.addEventListener('click', function(event){
        var anchor = event.target.closest('a[href^="#"]');
        if(!anchor) return;
        // reset link apperance 
        toc.clickScrolling = true;
        resetAnchors(toc, anchor);
        // close toc if expanded on mobile
        toggleToc(toc, true);
      });

      // check when a new section enters the viewport
      var intersectionObserverSupported = ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype);
      if(intersectionObserverSupported) {
        var observer = new IntersectionObserver(
          function(entries, observer) { 
            entries.forEach(function(entry){
              if(!toc.clickScrolling) { // do not update classes if user clicked on a link
                getVisibleSection(toc);
              }
            });
          }, 
          {
            threshold: [0, 0.1],
            rootMargin: "0px 0px -70% 0px"
          }
        );

        for(var i = 0; i < toc.sections.length; i++) {
          observer.observe(toc.sections[i]);
        }
      }

      // detect the end of scrolling -> reactivate IntersectionObserver on scroll
      toc.element.addEventListener('toc-scroll', function(event){
        toc.clickScrolling = false;
      });
    }

    // custom event emitted when window is resized
    toc.element.addEventListener('toc-resize', function(event){
      checkTocLayour(toc);
    });

    // collapsed version only (mobile)
    initCollapsedVersion(toc);
  };

  function resetAnchors(toc, anchor) {
    if(!anchor) return;
    for(var i = 0; i < toc.anchors.length; i++) Util.removeClass(toc.anchors[i], 'toc__link--selected');
    Util.addClass(anchor, 'toc__link--selected');
  };

  function getVisibleSection(toc) {
    if(toc.intervalID) {
      clearInterval(toc.intervalID);
    }
    toc.intervalID = setTimeout(function(){
      var halfWindowHeight = window.innerHeight/2,
      index = -1;
      for(var i = 0; i < toc.sections.length; i++) {
        var top = toc.sections[i].getBoundingClientRect().top;
        if(top < halfWindowHeight) index = i;
      }
      if(index > -1) {
        resetAnchors(toc, toc.anchors[index]);
      }
      toc.intervalID = false;
    }, 100);
  };

  function checkTocLayour(toc) {
    if(toc.isStatic) return;
    toc.layout = getComputedStyle(toc.element, ':before').getPropertyValue('content').replace(/\'|"/g, '');
    Util.toggleClass(toc.element, toc.staticLayoutClass, toc.layout == 'static');
    if(toc.content) Util.toggleClass(toc.content, toc.contentStaticLayoutClass, toc.layout == 'static');
  };

  function initCollapsedVersion(toc) { // collapsed version only (mobile)
    if(toc.controller.length < 1) return;
    
    // toggle nav visibility
    toc.controller[0].addEventListener('click', function(event){
      var isOpen = Util.hasClass(toc.element, toc.expandedClass);
      toggleToc(toc, isOpen);
    });

    // close expanded version on esc
    toc.element.addEventListener('keydown', function(event){
      if(toc.layout == 'static') return;
      if( (event.keyCode && event.keyCode == 27) || (event.key && event.key.toLowerCase() == 'escape') ) {
        toggleToc(toc, true);
        toc.controller[0].focus();
      }
    });
  };

  function toggleToc(toc, bool) { // collapsed version only (mobile)
    // toggle mobile version
    Util.toggleClass(toc.element, toc.expandedClass, !bool);
    bool ? toc.controller[0].removeAttribute('aria-expanded') : toc.controller[0].setAttribute('aria-expanded', 'true');
    if(!bool && toc.anchors.length > 0) {
      toc.anchors[0].focus();
    }
  };
  
  var tocs = document.getElementsByClassName('js-toc');

  var tocsArray = [];
	if( tocs.length > 0) {
		for( var i = 0; i < tocs.length; i++) {
			(function(i){ tocsArray.push(new Toc(tocs[i])); })(i);
    }

    // listen to window scroll -> reset clickScrolling property
    var scrollId = false,
      resizeId = false,
      scrollEvent = new CustomEvent('toc-scroll'),
      resizeEvent = new CustomEvent('toc-resize');
      
    window.addEventListener('scroll', function() {
      clearTimeout(scrollId);
      scrollId = setTimeout(doneScrolling, 100);
    });

    window.addEventListener('resize', function() {
      clearTimeout(resizeId);
      scrollId = setTimeout(doneResizing, 100);
    });

    function doneScrolling() {
      for( var i = 0; i < tocsArray.length; i++) {
        (function(i){tocsArray[i].element.dispatchEvent(scrollEvent)})(i);
      };
    };

    function doneResizing() {
      for( var i = 0; i < tocsArray.length; i++) {
        (function(i){tocsArray[i].element.dispatchEvent(resizeEvent)})(i);
      };
    };
  }
}());
// File#: _3_mega-site-navigation
// Usage: codyhouse.co/license
(function() {
  var MegaNav = function(element) {
    this.element = element;
    this.search = this.element.getElementsByClassName('js-mega-nav__search');
    this.searchActiveController = false;
    this.menu = this.element.getElementsByClassName('js-mega-nav__nav');
    this.menuItems = this.menu[0].getElementsByClassName('js-mega-nav__item');
    this.menuActiveController = false;
    this.itemExpClass = 'mega-nav__item--expanded';
    this.classIconBtn = 'mega-nav__icon-btn--state-b';
    this.classSearchVisible = 'mega-nav__search--is-visible';
    this.classNavVisible = 'mega-nav__nav--is-visible';
    this.classMobileLayout = 'mega-nav--mobile';
    this.classDesktopLayout = 'mega-nav--desktop';
    this.layout = 'mobile';
    // store dropdown elements (if present)
    this.dropdown = this.element.getElementsByClassName('js-dropdown');
    // expanded class - added to header when subnav is open
    this.expandedClass = 'mega-nav--expanded';
    // check if subnav should open on hover
    this.hover = this.element.getAttribute('data-hover') && this.element.getAttribute('data-hover') == 'on';
    initMegaNav(this);
  };

  function initMegaNav(megaNav) {
    setMegaNavLayout(megaNav); // switch between mobile/desktop layout
    initSearch(megaNav); // controll search navigation
    initMenu(megaNav); // control main menu nav - mobile only
    initSubNav(megaNav); // toggle sub navigation visibility

    megaNav.element.addEventListener('update-menu-layout', function(event){
      setMegaNavLayout(megaNav); // window resize - update layout
    });
  };

  function setMegaNavLayout(megaNav) {
    var layout = getComputedStyle(megaNav.element, ':before').getPropertyValue('content').replace(/\'|"/g, '');
    if(layout == megaNav.layout) return;
    megaNav.layout = layout;
    Util.toggleClass(megaNav.element, megaNav.classDesktopLayout, megaNav.layout == 'desktop');
    Util.toggleClass(megaNav.element, megaNav.classMobileLayout, megaNav.layout != 'desktop');
    if(megaNav.layout == 'desktop') {
      closeSubNav(megaNav, false);
      // if the mega navigation has dropdown elements -> make sure they are in the right position (viewport awareness)
      triggerDropdownPosition(megaNav);
    }
    closeSearch(megaNav, false);
    resetMegaNavOffset(megaNav); // reset header offset top value
    resetNavAppearance(megaNav); // reset nav expanded appearance
  };

  function resetMegaNavOffset(megaNav) {
    document.documentElement.style.setProperty('--mega-nav-offset-y', megaNav.element.getBoundingClientRect().top+'px');
  };

  function closeNavigation(megaNav) { // triggered by Esc key press
    // close search
    closeSearch(megaNav);
    // close nav
    if(Util.hasClass(megaNav.menu[0], megaNav.classNavVisible)) {
      toggleMenu(megaNav, megaNav.menu[0], 'menuActiveController', megaNav.classNavVisible, megaNav.menuActiveController, true);
    }
    //close subnav
    closeSubNav(megaNav, false);
    resetNavAppearance(megaNav); // reset nav expanded appearance
  };

  function closeFocusNavigation(megaNav) { // triggered by Tab key pressed
    // close search when focus is lost
    if(Util.hasClass(megaNav.search[0], megaNav.classSearchVisible) && !document.activeElement.closest('.js-mega-nav__search')) {
      toggleMenu(megaNav, megaNav.search[0], 'searchActiveController', megaNav.classSearchVisible, megaNav.searchActiveController, true);
    }
    // close nav when focus is lost
    if(Util.hasClass(megaNav.menu[0], megaNav.classNavVisible) && !document.activeElement.closest('.js-mega-nav__nav')) {
      toggleMenu(megaNav, megaNav.menu[0], 'menuActiveController', megaNav.classNavVisible, megaNav.menuActiveController, true);
    }
    // close subnav when focus is lost
    for(var i = 0; i < megaNav.menuItems.length; i++) {
      if(!Util.hasClass(megaNav.menuItems[i], megaNav.itemExpClass)) continue;
      var parentItem = document.activeElement.closest('.js-mega-nav__item');
      if(parentItem && parentItem == megaNav.menuItems[i]) continue;
      closeSingleSubnav(megaNav, i);
    }
    resetNavAppearance(megaNav); // reset nav expanded appearance
  };

  function closeSearch(megaNav, bool) {
    if(megaNav.search.length < 1) return;
    if(Util.hasClass(megaNav.search[0], megaNav.classSearchVisible)) {
      toggleMenu(megaNav, megaNav.search[0], 'searchActiveController', megaNav.classSearchVisible, megaNav.searchActiveController, bool);
    }
  } ;

  function initSearch(megaNav) {
    if(megaNav.search.length == 0) return;
    // toggle search
    megaNav.searchToggles = document.querySelectorAll('[aria-controls="'+megaNav.search[0].getAttribute('id')+'"]');
    for(var i = 0; i < megaNav.searchToggles.length; i++) {(function(i){
      megaNav.searchToggles[i].addEventListener('click', function(event){
        // toggle search
        toggleMenu(megaNav, megaNav.search[0], 'searchActiveController', megaNav.classSearchVisible, megaNav.searchToggles[i], true);
        // close nav if it was open
        if(Util.hasClass(megaNav.menu[0], megaNav.classNavVisible)) {
          toggleMenu(megaNav, megaNav.menu[0], 'menuActiveController', megaNav.classNavVisible, megaNav.menuActiveController, false);
        }
        // close subnavigation if open
        closeSubNav(megaNav, false);
        resetNavAppearance(megaNav); // reset nav expanded appearance
      });
    })(i);}
  };

  function initMenu(megaNav) {
    if(megaNav.menu.length == 0) return;
    // toggle nav
    megaNav.menuToggles = document.querySelectorAll('[aria-controls="'+megaNav.menu[0].getAttribute('id')+'"]');
    for(var i = 0; i < megaNav.menuToggles.length; i++) {(function(i){
      megaNav.menuToggles[i].addEventListener('click', function(event){
        // toggle nav
        toggleMenu(megaNav, megaNav.menu[0], 'menuActiveController', megaNav.classNavVisible, megaNav.menuToggles[i], true);
        // close search if it was open
        if(Util.hasClass(megaNav.search[0], megaNav.classSearchVisible)) {
          toggleMenu(megaNav, megaNav.search[0], 'searchActiveController', megaNav.classSearchVisible, megaNav.searchActiveController, false);
        }
        resetNavAppearance(megaNav); // reset nav expanded appearance
      });
    })(i);}
  };

  function toggleMenu(megaNav, element, controller, visibleClass, toggle, moveFocus) {
    var menuIsVisible = Util.hasClass(element, visibleClass);
    Util.toggleClass(element, visibleClass, !menuIsVisible);
    Util.toggleClass(toggle, megaNav.classIconBtn, !menuIsVisible);
    menuIsVisible ? toggle.removeAttribute('aria-expanded') : toggle.setAttribute('aria-expanded', 'true');
    if(menuIsVisible) {
      if(toggle && moveFocus) toggle.focus();
      megaNav[controller] = false;
    } else {
      if(toggle) megaNav[controller] = toggle;
      getFirstFocusable(element).focus(); // move focus to first focusable element
    }
  };

  function getFirstFocusable(element) {
    var focusableEle = element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary'),
      firstFocusable = false;
    for(var i = 0; i < focusableEle.length; i++) {
      if( focusableEle[i].offsetWidth || focusableEle[i].offsetHeight || focusableEle[i].getClientRects().length ) {
        firstFocusable = focusableEle[i];
        break;
      }
    }
    return firstFocusable;
  };

  function initSubNav(megaNav) {
    // toggle subnavigation visibility
    megaNav.element.addEventListener('click', function(event){
      toggleSubNav(megaNav, event, 'click');
    });

    if(megaNav.hover) { // data-hover="on" => use mouse events
      megaNav.element.addEventListener('mouseover', function(event) {
        if(megaNav.layout != 'desktop') return;
        toggleSubNav(megaNav, event, 'mouseover')
      });

      megaNav.element.addEventListener('mouseout', function(event){
        if(megaNav.layout != 'desktop') return;
        var mainItem = event.target.closest('.js-mega-nav__item');
        if(!mainItem) return;
        var triggerBtn = mainItem.getElementsByClassName('js-mega-nav__control');
        if(triggerBtn.length < 1) return;
        var itemExpanded = Util.hasClass(mainItem, megaNav.itemExpClass);
        if(!itemExpanded) return;
        var mainItemHover = event.relatedTarget;
        if(mainItemHover && mainItem.contains(mainItemHover)) return;

        Util.toggleClass(mainItem, megaNav.itemExpClass, !itemExpanded);
        itemExpanded ? triggerBtn[0].removeAttribute('aria-expanded') : triggerBtn[0].setAttribute('aria-expanded', 'true');
      });
    }
  };

  function toggleSubNav(megaNav, event, eventType) {
    var triggerBtn = event.target.closest('.js-mega-nav__control');
    if(!triggerBtn) return;
    var mainItem = triggerBtn.closest('.js-mega-nav__item');
    if(!mainItem) return;
    var itemExpanded = Util.hasClass(mainItem, megaNav.itemExpClass);
    if(megaNav.hover && itemExpanded && megaNav.layout == 'desktop' && eventType != 'click') return;
    Util.toggleClass(mainItem, megaNav.itemExpClass, !itemExpanded);
    itemExpanded ? triggerBtn.removeAttribute('aria-expanded') : triggerBtn.setAttribute('aria-expanded', 'true');
    if(megaNav.layout == 'desktop' && !itemExpanded) closeSubNav(megaNav, mainItem);
    // close search if open
    closeSearch(megaNav, false);
    resetNavAppearance(megaNav); // reset nav expanded appearance
  };

  function closeSubNav(megaNav, selectedItem) {
    // close subnav when a new sub nav element is open
    if(megaNav.menuItems.length == 0 ) return;
    for(var i = 0; i < megaNav.menuItems.length; i++) {
      if(megaNav.menuItems[i] != selectedItem) closeSingleSubnav(megaNav, i);
    }
  };

  function closeSingleSubnav(megaNav, index) {
    Util.removeClass(megaNav.menuItems[index], megaNav.itemExpClass);
    var triggerBtn = megaNav.menuItems[index].getElementsByClassName('js-mega-nav__control');
    if(triggerBtn.length > 0) triggerBtn[0].removeAttribute('aria-expanded');
  };

  function triggerDropdownPosition(megaNav) {
    // emit custom event to properly place dropdown elements - viewport awarness
    if(megaNav.dropdown.length == 0) return;
    for(var i = 0; i < megaNav.dropdown.length; i++) {
      megaNav.dropdown[i].dispatchEvent(new CustomEvent('placeDropdown'));
    }
  };

  function resetNavAppearance(megaNav) {
    ( (megaNav.element.getElementsByClassName(megaNav.itemExpClass).length > 0 && megaNav.layout == 'desktop') || megaNav.element.getElementsByClassName(megaNav.classSearchVisible).length > 0 ||(megaNav.element.getElementsByClassName(megaNav.classNavVisible).length > 0 && megaNav.layout == 'mobile'))
      ? Util.addClass(megaNav.element, megaNav.expandedClass)
      : Util.removeClass(megaNav.element, megaNav.expandedClass);
  };

  //initialize the MegaNav objects
  var megaNav = document.getElementsByClassName('js-mega-nav');
  if(megaNav.length > 0) {
    var megaNavArray = [];
    for(var i = 0; i < megaNav.length; i++) {
      (function(i){megaNavArray.push(new MegaNav(megaNav[i]));})(i);
    }

    // key events
    window.addEventListener('keyup', function(event){
      if( (event.keyCode && event.keyCode == 27) || (event.key && event.key.toLowerCase() == 'escape' )) { // listen for esc key events
        for(var i = 0; i < megaNavArray.length; i++) {(function(i){
          closeNavigation(megaNavArray[i]);
        })(i);}
      }
      // listen for tab key
      if( (event.keyCode && event.keyCode == 9) || (event.key && event.key.toLowerCase() == 'tab' )) { // close search or nav if it looses focus
        for(var i = 0; i < megaNavArray.length; i++) {(function(i){
          closeFocusNavigation(megaNavArray[i]);
        })(i);}
      }
    });

    window.addEventListener('click', function(event){
      if(!event.target.closest('.js-mega-nav')) closeNavigation(megaNavArray[0]);
    });

    // resize - update menu layout
    var resizingId = false,
      customEvent = new CustomEvent('update-menu-layout');
    window.addEventListener('resize', function(event){
      clearTimeout(resizingId);
      resizingId = setTimeout(doneResizing, 200);
    });

    function doneResizing() {
      for( var i = 0; i < megaNavArray.length; i++) {
        (function(i){megaNavArray[i].element.dispatchEvent(customEvent)})(i);
      };
    };

    (window.requestAnimationFrame) // init mega site nav layout
      ? window.requestAnimationFrame(doneResizing)
      : doneResizing();
  }
}());
(function() {
  var autocomplete = document.getElementsByClassName('js-autocomplete');
  if(autocomplete.length == 0) return;

  // static array of values - used as demo list of search results
  var searchValues = [
    {label: 'Inspector', category: 'Interface', url: 'basic-page.html'},
    {label: 'Timeline', category: 'Interface', url: 'basic-page.html'},
    {label: 'Comments', category: 'Syntax', url: 'basic-page.html'},
    {label: 'Structure', category: 'Syntax', url: 'basic-page.html'},
    {label: 'How invoicing works', category: 'Invoicing > Customers', url: 'basic-page.html'},
    {label: 'Taxes', category: 'Invoicing > Customers', url: 'basic-page.html'},
  ];

  // default values - visible when user has not started typing yet
  var defaultValues = [
    {label: 'Timeline', category: 'Interface', url: 'basic-page.html'},
    {label: 'Taxes', category: 'Testing > Customers', url: 'basic-page.html'},
  ];

  new Autocomplete({
    element: autocomplete[0],
    characters: 0,
    searchData: function(query, cb) {
      // This is the function used to retrieve search results. 
      // It is a demo function - you should replace it with your custom code.
      var data = defaultValues;
      if(query.length > 1) {
        data = searchValues.filter(function(item){
          return item['label'].toLowerCase().indexOf(query.toLowerCase()) > -1 || item['category'].toLowerCase().indexOf(query.toLowerCase()) > -1;
        });
      }
      // NOTE: make sure to call the callback function and pass the data array as its argument 👇
      cb(data);
    }
  });
  
}());