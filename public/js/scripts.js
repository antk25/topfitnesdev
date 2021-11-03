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
// File#: _1_back-to-top
// Usage: codyhouse.co/license
(function() {
  var backTop = document.getElementsByClassName('js-back-to-top')[0];
  if( backTop ) {
    var dataElement = backTop.getAttribute('data-element');
    var scrollElement = dataElement ? document.querySelector(dataElement) : window;
    var scrollDuration = parseInt(backTop.getAttribute('data-duration')) || 300, //scroll to top duration
      scrollOffsetInit = parseInt(backTop.getAttribute('data-offset-in')) || parseInt(backTop.getAttribute('data-offset')) || 0, //show back-to-top if scrolling > scrollOffset
      scrollOffsetOutInit = parseInt(backTop.getAttribute('data-offset-out')) || 0, 
      scrollOffset = 0,
      scrollOffsetOut = 0,
      scrolling = false;

    // check if target-in/target-out have been set
    var targetIn = backTop.getAttribute('data-target-in') ? document.querySelector(backTop.getAttribute('data-target-in')) : false,
      targetOut = backTop.getAttribute('data-target-out') ? document.querySelector(backTop.getAttribute('data-target-out')) : false;

    updateOffsets();
    
    //detect click on back-to-top link
    backTop.addEventListener('click', function(event) {
      event.preventDefault();
      if(!window.requestAnimationFrame) {
        scrollElement.scrollTo(0, 0);
      } else {
        dataElement ? Util.scrollTo(0, scrollDuration, false, scrollElement) : Util.scrollTo(0, scrollDuration);
      } 
      //move the focus to the #top-element - don't break keyboard navigation
      Util.moveFocus(document.getElementById(backTop.getAttribute('href').replace('#', '')));
    });
    
    //listen to the window scroll and update back-to-top visibility
    checkBackToTop();
    if (scrollOffset > 0 || scrollOffsetOut > 0) {
      scrollElement.addEventListener("scroll", function(event) {
        if( !scrolling ) {
          scrolling = true;
          (!window.requestAnimationFrame) ? setTimeout(function(){checkBackToTop();}, 250) : window.requestAnimationFrame(checkBackToTop);
        }
      });
    }

    function checkBackToTop() {
      updateOffsets();
      var windowTop = scrollElement.scrollTop || document.documentElement.scrollTop;
      if(!dataElement) windowTop = window.scrollY || document.documentElement.scrollTop;
      var condition =  windowTop >= scrollOffset;
      if(scrollOffsetOut > 0) {
        condition = (windowTop >= scrollOffset) && (window.innerHeight + windowTop < scrollOffsetOut);
      }
      Util.toggleClass(backTop, 'back-to-top--is-visible', condition);
      scrolling = false;
    }

    function updateOffsets() {
      scrollOffset = getOffset(targetIn, scrollOffsetInit, true);
      scrollOffsetOut = getOffset(targetOut, scrollOffsetOutInit);
    }

    function getOffset(target, startOffset, bool) {
      var offset = 0;
      if(target) {
        var windowTop = scrollElement.scrollTop || document.documentElement.scrollTop;
        if(!dataElement) windowTop = window.scrollY || document.documentElement.scrollTop;
        var boundingClientRect = target.getBoundingClientRect();
        offset = bool ? boundingClientRect.bottom : boundingClientRect.top;
        offset = offset + windowTop;
      }
      if(startOffset && startOffset) {
        offset = offset + parseInt(startOffset);
      }
      return offset;
    }
  }
}());
// File#: _1_choice-accordion
// Usage: codyhouse.co/license
(function() {
  var ChoiceAccordion = function(element) {
    this.element = element;
    this.btns = this.element.getElementsByClassName('js-choice-accordion__btn');
    this.inputs = getChoiceInput(this);
    this.contents = getChoiceContent(this);
    this.isRadio = this.inputs[0].type == 'radio';
    this.animateHeight = (this.element.getAttribute('data-animation') == 'on');
    initAccordion(this);
    resetCheckedStatus(this, false); // set initial classes
    initChoiceAccordionEvent(this); // add listeners
  };

  function getChoiceInput(element) { // store input elements in an object property
    var inputs = [],
      fallbacks = element.element.getElementsByClassName('js-choice-accordion__fallback');
    for(var i = 0; i < fallbacks.length; i++) {
      inputs.push(fallbacks[i].getElementsByTagName('input')[0]);
    }
    return inputs;
  }

  function getChoiceContent(element) { // store content elements in an object property
    var contents = [];
    for(var i = 0; i < element.btns.length; i++) {
      var content = Util.getChildrenByClassName(element.btns[i].parentNode, 'js-choice-accordion__panel');
      if(content.length > 0 ) contents.push(content[0]);
      else  contents.push(false);
    }
    return contents;
  }

  function initAccordion(element) { //set initial aria attributes
		for( var i = 0; i < element.inputs.length; i++) {
      if(!element.contents[i]) return; // no content to trigger
      var isOpen = element.inputs[i].checked,
        id = element.inputs[i].getAttribute('id');
      if(!id) id = 'choice-accordion-header-'+i;
      
      Util.setAttributes(element.inputs[i], {'aria-expanded': isOpen, 'aria-controls': 'choice-accordion-content-'+i, 'id': id});
      Util.setAttributes(element.contents[i], {'aria-labelledby': id, 'id': 'choice-accordion-content-'+i});
      Util.toggleClass(element.contents[i], 'is-hidden', !isOpen);
		}
  };

  function initChoiceAccordionEvent(choiceAcc) {
    choiceAcc.element.addEventListener('click', function(event){ // update status on click
      if(Util.getIndexInArray(choiceAcc.inputs, event.target) > -1) return; // triggered by change in input element -> will be detected by the 'change' event

      var selectedBtn = event.target.closest('.js-choice-accordion__btn');
      if(!selectedBtn) return;
      
      var index = Util.getIndexInArray(choiceAcc.btns, selectedBtn);
      if(choiceAcc.isRadio && choiceAcc.inputs[index].checked) { // radio input already checked
        choiceAcc.inputs[index].focus(); // move focus to input element
        return; 
      }

      choiceAcc.inputs[index].checked = !choiceAcc.inputs[index].checked;
      choiceAcc.inputs[index].dispatchEvent(new CustomEvent('change')); // trigger change event
      choiceAcc.inputs[index].focus(); // move focus to input element
    });

    for(var i = 0; i < choiceAcc.btns.length; i++) {(function(i){ // change + focus events
      choiceAcc.inputs[i].addEventListener('change', function(event){
        choiceAcc.isRadio ? resetCheckedStatus(choiceAcc, true) : resetSingleStatus(choiceAcc, i, true);
      });

      choiceAcc.inputs[i].addEventListener('focus', function(event){
        resetFocusStatus(choiceAcc, i, true);
      });

      choiceAcc.inputs[i].addEventListener('blur', function(event){
        resetFocusStatus(choiceAcc, i, false);
      });
    })(i);}
  };

  function resetCheckedStatus(choiceAcc, bool) {
    for(var i = 0; i < choiceAcc.btns.length; i++) {
      resetSingleStatus(choiceAcc, i, bool);
    }
  };

  function resetSingleStatus(choiceAcc, index, bool) { // toggle .choice-accordion__btn--checked class
    Util.toggleClass(choiceAcc.btns[index], 'choice-accordion__btn--checked', choiceAcc.inputs[index].checked);
    if(bool) resetSingleContent(choiceAcc, index, choiceAcc.inputs[index].checked); // no need to run this when component is initialized
  };

  function resetFocusStatus(choiceAcc, index, bool) { // toggle .choice-accordion__btn--focus class
    Util.toggleClass(choiceAcc.btns[index], 'choice-accordion__btn--focus', bool);
  };

  function resetSingleContent(choiceAcc, index, bool) { // show accordion content
    var input = choiceAcc.inputs[index],
      content = choiceAcc.contents[index];

		if(bool && content) Util.removeClass(content, 'is-hidden');
		input.setAttribute('aria-expanded', bool);

		if(choiceAcc.animateHeight && content) {
			//store initial and final height - animate accordion content height
			var initHeight = !bool ? content.offsetHeight: 0,
				finalHeight = !bool ? 0 : content.offsetHeight;
    }

		if(window.requestAnimationFrame && choiceAcc.animateHeight && !reducedMotion && content) {
			Util.setHeight(initHeight, finalHeight, content, 200, function(){
				resetContentVisibility(content, bool);
			});
		} else {
			resetContentVisibility(content, bool);
		}
  };

	function resetContentVisibility(content, bool) {
    if(!content) return;
		Util.toggleClass(content, 'is-hidden', !bool);
		content.removeAttribute("style");
	};

  //initialize the ChoiceAccordions objects
  var choiceAccordion = document.getElementsByClassName('js-choice-accordion'),
    reducedMotion = Util.osHasReducedMotion();
	if( choiceAccordion.length > 0 ) {
		for( var i = 0; i < choiceAccordion.length; i++) {
			(function(i){new ChoiceAccordion(choiceAccordion[i]);})(i);
		}
	};
}());
// File#: _1_choice-buttons
// Usage: codyhouse.co/license
(function() {
  var ChoiceButton = function(element) {
    this.element = element;
    this.btns = this.element.getElementsByClassName('js-choice-btn');
    this.inputs = getChoiceInput(this);
    this.isRadio = this.inputs[0].type.toString() == 'radio';
    resetCheckedStatus(this); // set initial classes
    initChoiceButtonEvent(this); // add listeners
  };

  function getChoiceInput(element) { // store input elements in an object property
    var inputs = [];
    for(var i = 0; i < element.btns.length; i++) {
      inputs.push(element.btns[i].getElementsByTagName('input')[0]);
    }
    return inputs;
  };

  function initChoiceButtonEvent(choiceBtn) {
    choiceBtn.element.addEventListener('click', function(event){ // update status on click
      if(Util.getIndexInArray(choiceBtn.inputs, event.target) > -1) return; // triggered by change in input element -> will be detected by the 'change' event

      var selectedBtn = event.target.closest('.js-choice-btn');
      if(!selectedBtn) return;
      var index = Util.getIndexInArray(choiceBtn.btns, selectedBtn);
      if(choiceBtn.isRadio && choiceBtn.inputs[index].checked) { // radio input already checked
        choiceBtn.inputs[index].focus(); // move focus to input element
        return; 
      }

      choiceBtn.inputs[index].checked = !choiceBtn.inputs[index].checked;
      choiceBtn.inputs[index].dispatchEvent(new CustomEvent('change')); // trigger change event
      choiceBtn.inputs[index].focus(); // move focus to input element
    });

    for(var i = 0; i < choiceBtn.btns.length; i++) {(function(i){ // change + focus events
      choiceBtn.inputs[i].addEventListener('change', function(event){
        choiceBtn.isRadio ? resetCheckedStatus(choiceBtn) : resetSingleStatus(choiceBtn, i);
      });

      choiceBtn.inputs[i].addEventListener('focus', function(event){
        resetFocusStatus(choiceBtn, i, true);
      });

      choiceBtn.inputs[i].addEventListener('blur', function(event){
        resetFocusStatus(choiceBtn, i, false);
      });
    })(i);}
  };

  function resetCheckedStatus(choiceBtn) {
    for(var i = 0; i < choiceBtn.btns.length; i++) {
      resetSingleStatus(choiceBtn, i);
    }
  };

  function resetSingleStatus(choiceBtn, index) { // toggle .choice-btn--checked class
    Util.toggleClass(choiceBtn.btns[index], 'choice-btn--checked', choiceBtn.inputs[index].checked);
  };

  function resetFocusStatus(choiceBtn, index, bool) { // toggle .choice-btn--focus class
    Util.toggleClass(choiceBtn.btns[index], 'choice-btn--focus', bool);
  };

  //initialize the ChoiceButtons objects
	var choiceButton = document.getElementsByClassName('js-choice-btns');
	if( choiceButton.length > 0 ) {
		for( var i = 0; i < choiceButton.length; i++) {
			(function(i){new ChoiceButton(choiceButton[i]);})(i);
		}
	};
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
// File#: _1_floating-action-button
// Usage: codyhouse.co/license
(function() {
  var Fab = function(element) {
    this.element = element;
    this.fabButton = this.element.getElementsByClassName('js-fab__btn');
    this.fabPopover = this.element.getElementsByClassName('js-fab__popover');
    this.fabPopoverInner = this.element.getElementsByClassName('js-fab__popover-inner');
    this.visibleClass = 'fab--active';
    this.animating = false;
    // focusable elements
    this.firstFocusable = false;
    this.lastFocusable = false;
    // offset variables
    this.offsetIn = 0;
    this.offsetOut = 0;
    this.targetIn = this.element.getAttribute('data-target-in') ? document.querySelector(this.element.getAttribute('data-target-in')) : false;
    this.targetOut = this.element.getAttribute('data-target-out') ? document.querySelector(this.element.getAttribute('data-target-out')) : false;
    if(this.fabButton.length < 1 || this.fabPopover.length < 1) return;
    initFab(this);
  };

  // public methods
  Fab.prototype.setVariables = function() {
    setFabVariables(this);
  };

  Fab.prototype.resetVisibility = function() {
    resetFabVisibility(this);
  };

  // private methods
  function initFab(element) {
    resetFabVisibility(element);
    setFabVariables(element);
    initFabEvents(element);
  };

  function setFabVariables(element) {
    // set CSS variables
    element.fabPopoverInner[0].style.height = '';
    var height = element.fabPopover[0].offsetHeight+'px';

    element.element.style.setProperty('--fab-popover-height', height);
    element.fabPopoverInner[0].style.height = height;
  };

  function initFabEvents(element) {
    if(document.fonts) {
      // wait for fonts to be loaded and set popover height
      document.fonts.ready.then(function() {
        setFabVariables(element);
      });
    }

    // toggle popover when clicking on fab button
    element.fabButton[0].addEventListener('click', function() {
      if(element.animating) return;
      element.animating = true;
      toggleFab(element);
    });

    // close popover when clicking on fab background
    element.element.addEventListener('click', function(event){
      if(!event.target.closest('.js-fab__btn') && !event.target.closest('.js-fab__popover-inner')) toggleFab(element);
    });

    // trap focus
    element.element.addEventListener('keydown', function(event){
      if( event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' ) {
        //trap focus inside popover
        trapFocus(element, event);
      } else if(event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape' ) {
        if(Util.hasClass(element.element, element.visibleClass)) toggleFab(element);
      }
    });
  };

  function toggleFab(element) {
    var isOpen = Util.hasClass(element.element, element.visibleClass);

    if(isOpen) {
      Util.removeClass(element.element, element.visibleClass);
      element.fabButton[0].removeAttribute('aria-expanded');
      element.fabButton[0].focus();
    } else {
      Util.addClass(element.element, element.visibleClass);
      element.fabButton[0].setAttribute('aria-expanded', 'true');
    }

    // wait for the end of the transition
    element.fabPopover[0].addEventListener('transitionend', function cb(){
      element.animating = false;
      element.fabPopover[0].removeEventListener('transitionend', cb);
      if(!isOpen) focusPopover(element);
    });
  };

  function focusPopover(element) {
    getFocusableElements(element);
    if(element.firstFocusable) {
      element.firstFocusable.focus();
    }
  };

  // trapping focus
  function getFocusableElements(element) {
    // get all focusable elements inside the popover
    var allFocusable = element.fabPopover[0].querySelectorAll(focusableElString);
    getFirstVisible(element, allFocusable);
    getLastVisible(element, allFocusable);
  };

  function getFirstVisible(element, focusableElments) {
    // get first visible focusable element inside the popover
    for(var i = 0; i < focusableElments.length; i++) {
      if( isVisible(focusableElments[i]) ) {
        element.firstFocusable = focusableElments[i];
        break;
      }
    }
  };

  function getLastVisible(element, focusableElments) {
    // get last visible focusable element inside the popover
    for(var i = focusableElments.length - 1; i >= 0; i--) {
      if( isVisible(focusableElments[i]) ) {
        element.lastFocusable = focusableElments[i];
        break;
      }
    }
  };

  function trapFocus(element, event) {
    if( element.firstFocusable == document.activeElement && event.shiftKey) {
      //on Shift+Tab -> focus last focusable element when focus moves out of popover
      event.preventDefault();
      element.lastFocusable.focus();
    }
    if( element.lastFocusable == document.activeElement && !event.shiftKey) {
      //on Tab -> focus first focusable element when focus moves out of popover
      event.preventDefault();
      element.firstFocusable.focus();
    }
  };

  function isVisible(element) {
    // check if element is visible
    return element.offsetWidth || element.offsetHeight || element.getClientRects().length;
  };

  // offset functions
  function resetFabVisibility(element) {
    getFabBtnOffsets(element); // get offset values - show/hide fab button
    var scrollTop = document.documentElement.scrollTop,
      topTarget = false,
      bottomTarget = false;
    if(element.offsetIn <= scrollTop || element.offsetIn == 0) {
      topTarget = true;
    }
    if(element.offsetOut == 0 || scrollTop < element.offsetOut) {
      bottomTarget = true;
    }
    Util.toggleClass(element.element, 'fab--in', bottomTarget && topTarget);

    // if popover is visible -> close it
    if( (!bottomTarget || !topTarget) && Util.hasClass(element.element, element.visibleClass)) toggleFab(element);
  };

  function getFabBtnOffsets(element) { // get offset in and offset out values
    // update offsetIn
    element.offsetIn = 0;
    if(element.targetIn) {
      var boundingClientRect = element.targetIn.getBoundingClientRect();
      element.offsetIn = boundingClientRect.top + document.documentElement.scrollTop + boundingClientRect.height;
    }
    var dataOffsetIn = element.element.getAttribute('data-offset-in');
    if(dataOffsetIn) {
      element.offsetIn = element.offsetIn + parseInt(dataOffsetIn);
    }
    // update offsetOut
    element.offsetOut = 0;
    if(element.targetOut) {
      var boundingClientRect = element.targetOut.getBoundingClientRect();
      element.offsetOut = boundingClientRect.top + document.documentElement.scrollTop - window.innerHeight;
    }
    var dataOffsetOut = element.element.getAttribute('data-offset-out');
    if(dataOffsetOut) {
      element.offsetOut = element.offsetOut + parseInt(dataOffsetOut);
    }
  };

  //initialize the Fab objects
  var fabs = document.getElementsByClassName('js-fab');
  // generic focusable elements string selector
  var focusableElString = '[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary';
  if( fabs.length > 0 ) {
    var fabsArray = [];
    for( var i = 0; i < fabs.length; i++) {
      (function(i){fabsArray.push(new Fab(fabs[i]));})(i);
    }

    // reset fab height on resize
    var resizingId = false;

    window.addEventListener('resize', function() {
      clearTimeout(resizingId);
      resizingId = setTimeout(doneResizing);
    });

    window.addEventListener('scroll', function() {
      clearTimeout(resizingId);
      resizingId = setTimeout(doneScrolling);
    });

    function doneResizing() {
      fabsArray.forEach(function(element){
        element.setVariables();
        element.resetVisibility();
      });
    };

    function doneScrolling() {
      fabsArray.forEach(function(element){
        element.resetVisibility();
      });
    };
  }
}());
// File#: _1_form-validator
// Usage: codyhouse.co/license
(function() {
  var FormValidator = function(opts) {
    this.options = Util.extend(FormValidator.defaults , opts);
		this.element = this.options.element;
    this.input = [];
    this.textarea = [];
    this.select = [];
    this.errorFields = [];
    this.errorFieldListeners = [];
		initFormValidator(this);
	};

  //public functions
  FormValidator.prototype.validate = function(cb) {
    validateForm(this);
    if(cb) cb(this.errorFields);
  };

  // private methods
  function initFormValidator(formValidator) {
    formValidator.input = formValidator.element.querySelectorAll('input');
    formValidator.textarea = formValidator.element.querySelectorAll('textarea');
    formValidator.select = formValidator.element.querySelectorAll('select');
  };

  function validateForm(formValidator) {
    // reset input with errors
    formValidator.errorFields = []; 
    // remove change/input events from fields with error
    resetEventListeners(formValidator);
    
    // loop through fields and push to errorFields if there are errors
    for(var i = 0; i < formValidator.input.length; i++) {
      validateField(formValidator, formValidator.input[i]);
    }

    for(var i = 0; i < formValidator.textarea.length; i++) {
      validateField(formValidator, formValidator.textarea[i]);
    }

    for(var i = 0; i < formValidator.select.length; i++) {
      validateField(formValidator, formValidator.select[i]);
    }

    // show errors if any was found
    for(var i = 0; i < formValidator.errorFields.length; i++) {
      showError(formValidator, formValidator.errorFields[i]);
    }

    // move focus to first field with error
    if(formValidator.errorFields.length > 0) formValidator.errorFields[0].focus();
  };

  function validateField(formValidator, field) {
    if(!field.checkValidity()) {
      formValidator.errorFields.push(field);
      return;
    }
    // check for custom functions
    var customValidate = field.getAttribute('data-validate');
    if(customValidate && formValidator.options.customValidate[customValidate]) {
      formValidator.options.customValidate[customValidate](field, function(result) {
        if(!result) formValidator.errorFields.push(field);
      });
    }
  };

  function showError(formValidator, field) {
    // add error classes
    toggleErrorClasses(formValidator, field, true);

    // add event listener
    var index = formValidator.errorFieldListeners.length;
    formValidator.errorFieldListeners[index] = function() {
      toggleErrorClasses(formValidator, field, false);
      field.removeEventListener('change', formValidator.errorFieldListeners[index]);
      field.removeEventListener('input', formValidator.errorFieldListeners[index]);
    };
    field.addEventListener('change', formValidator.errorFieldListeners[index]);
    field.addEventListener('input', formValidator.errorFieldListeners[index]);
  };

  function toggleErrorClasses(formValidator, field, bool) {
    bool ? Util.addClass(field, formValidator.options.inputErrorClass) : Util.removeClass(field, formValidator.options.inputErrorClass);
    if(formValidator.options.inputWrapperErrorClass) {
      var wrapper = field.closest('.js-form-validate__input-wrapper');
      if(wrapper) {
        bool ? Util.addClass(wrapper, formValidator.options.inputWrapperErrorClass) : Util.removeClass(wrapper, formValidator.options.inputWrapperErrorClass);
      }
    }
  };

  function resetEventListeners(formValidator) {
    for(var i = 0; i < formValidator.errorFields.length; i++) {
      toggleErrorClasses(formValidator, formValidator.errorFields[i], false);
      formValidator.errorFields[i].removeEventListener('change', formValidator.errorFieldListeners[i]);
      formValidator.errorFields[i].removeEventListener('input', formValidator.errorFieldListeners[i]);
    }

    formValidator.errorFields = [];
    formValidator.errorFieldListeners = [];
  };
  
  FormValidator.defaults = {
    element : '',
    inputErrorClass : 'form-control--error',
    inputWrapperErrorClass: 'form-validate__input-wrapper--error',
    customValidate: {}
  };
  window.FormValidator = FormValidator;
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
// File#: _1_menu
// Usage: codyhouse.co/license
(function() {
	var Menu = function(element) {
		this.element = element;
		this.elementId = this.element.getAttribute('id');
		this.menuItems = this.element.getElementsByClassName('js-menu__content');
		this.trigger = document.querySelectorAll('[aria-controls="'+this.elementId+'"]');
		this.selectedTrigger = false;
		this.menuIsOpen = false;
		this.initMenu();
		this.initMenuEvents();
	};	

	Menu.prototype.initMenu = function() {
		// init aria-labels
		for(var i = 0; i < this.trigger.length; i++) {
			Util.setAttributes(this.trigger[i], {'aria-expanded': 'false', 'aria-haspopup': 'true'});
		}
		// init tabindex
		for(var i = 0; i < this.menuItems.length; i++) {
			this.menuItems[i].setAttribute('tabindex', '0');
		}
	};

	Menu.prototype.initMenuEvents = function() {
		var self = this;
		for(var i = 0; i < this.trigger.length; i++) {(function(i){
			self.trigger[i].addEventListener('click', function(event){
				event.preventDefault();
				// if the menu had been previously opened by another trigger element -> close it first and reopen in the right position
				if(Util.hasClass(self.element, 'menu--is-visible') && self.selectedTrigger !=  self.trigger[i]) {
					self.toggleMenu(false, false); // close menu
				}
				// toggle menu
				self.selectedTrigger = self.trigger[i];
				self.toggleMenu(!Util.hasClass(self.element, 'menu--is-visible'), true);
			});
		})(i);}
		
		// keyboard events
		this.element.addEventListener('keydown', function(event) {
			// use up/down arrow to navigate list of menu items
			if( !Util.hasClass(event.target, 'js-menu__content') ) return;
			if( (event.keyCode && event.keyCode == 40) || (event.key && event.key.toLowerCase() == 'arrowdown') ) {
				self.navigateItems(event, 'next');
			} else if( (event.keyCode && event.keyCode == 38) || (event.key && event.key.toLowerCase() == 'arrowup') ) {
				self.navigateItems(event, 'prev');
			}
		});
	};

	Menu.prototype.toggleMenu = function(bool, moveFocus) {
		var self = this;
		// toggle menu visibility
		Util.toggleClass(this.element, 'menu--is-visible', bool);
		this.menuIsOpen = bool;
		if(bool) {
			this.selectedTrigger.setAttribute('aria-expanded', 'true');
			Util.moveFocus(this.menuItems[0]);
			this.element.addEventListener("transitionend", function(event) {Util.moveFocus(self.menuItems[0]);}, {once: true});
			// position the menu element
			this.positionMenu();
			// add class to menu trigger
			Util.addClass(this.selectedTrigger, 'menu-control--active');
		} else if(this.selectedTrigger) {
			this.selectedTrigger.setAttribute('aria-expanded', 'false');
			if(moveFocus) Util.moveFocus(this.selectedTrigger);
			// remove class from menu trigger
			Util.removeClass(this.selectedTrigger, 'menu-control--active');
			this.selectedTrigger = false;
		}
	};

	Menu.prototype.positionMenu = function(event, direction) {
		var selectedTriggerPosition = this.selectedTrigger.getBoundingClientRect(),
			menuOnTop = (window.innerHeight - selectedTriggerPosition.bottom) < selectedTriggerPosition.top;
			// menuOnTop = window.innerHeight < selectedTriggerPosition.bottom + this.element.offsetHeight;
			
		var left = selectedTriggerPosition.left,
			right = (window.innerWidth - selectedTriggerPosition.right),
			isRight = (window.innerWidth < selectedTriggerPosition.left + this.element.offsetWidth);

		var horizontal = isRight ? 'right: '+right+'px;' : 'left: '+left+'px;',
			vertical = menuOnTop
				? 'bottom: '+(window.innerHeight - selectedTriggerPosition.top)+'px;'
				: 'top: '+selectedTriggerPosition.bottom+'px;';
		// check right position is correct -> otherwise set left to 0
		if( isRight && (right + this.element.offsetWidth) > window.innerWidth) horizontal = 'left: '+ parseInt((window.innerWidth - this.element.offsetWidth)/2)+'px;';
		var maxHeight = menuOnTop ? selectedTriggerPosition.top - 20 : window.innerHeight - selectedTriggerPosition.bottom - 20;
		this.element.setAttribute('style', horizontal + vertical +'max-height:'+Math.floor(maxHeight)+'px;');
	};

	Menu.prototype.navigateItems = function(event, direction) {
		event.preventDefault();
		var index = Util.getIndexInArray(this.menuItems, event.target),
			nextIndex = direction == 'next' ? index + 1 : index - 1;
		if(nextIndex < 0) nextIndex = this.menuItems.length - 1;
		if(nextIndex > this.menuItems.length - 1) nextIndex = 0;
		Util.moveFocus(this.menuItems[nextIndex]);
	};

	Menu.prototype.checkMenuFocus = function() {
		var menuParent = document.activeElement.closest('.js-menu');
		if (!menuParent || !this.element.contains(menuParent)) this.toggleMenu(false, false);
	};

	Menu.prototype.checkMenuClick = function(target) {
		if( !this.element.contains(target) && !target.closest('[aria-controls="'+this.elementId+'"]')) this.toggleMenu(false);
	};

	window.Menu = Menu;

	//initialize the Menu objects
	var menus = document.getElementsByClassName('js-menu');
	if( menus.length > 0 ) {
		var menusArray = [];
		var scrollingContainers = [];
		for( var i = 0; i < menus.length; i++) {
			(function(i){
				menusArray.push(new Menu(menus[i]));
				var scrollableElement = menus[i].getAttribute('data-scrollable-element');
				if(scrollableElement && !scrollingContainers.includes(scrollableElement)) scrollingContainers.push(scrollableElement);
			})(i);
		}

		// listen for key events
		window.addEventListener('keyup', function(event){
			if( event.keyCode && event.keyCode == 9 || event.key && event.key.toLowerCase() == 'tab' ) {
				//close menu if focus is outside menu element
				menusArray.forEach(function(element){
					element.checkMenuFocus();
				});
			} else if( event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape' ) {
				// close menu on 'Esc'
				menusArray.forEach(function(element){
					element.toggleMenu(false, false);
				});
			} 
		});
		// close menu when clicking outside it
		window.addEventListener('click', function(event){
			menusArray.forEach(function(element){
				element.checkMenuClick(event.target);
			});
		});
		// on resize -> close all menu elements
		window.addEventListener('resize', function(event){
			menusArray.forEach(function(element){
				element.toggleMenu(false, false);
			});
		});
		// on scroll -> close all menu elements
		window.addEventListener('scroll', function(event){
			menusArray.forEach(function(element){
				if(element.menuIsOpen) element.toggleMenu(false, false);
			});
		});
		// take into account additinal scrollable containers
		for(var j = 0; j < scrollingContainers.length; j++) {
			var scrollingContainer = document.querySelector(scrollingContainers[j]);
			if(scrollingContainer) {
				scrollingContainer.addEventListener('scroll', function(event){
					menusArray.forEach(function(element){
						if(element.menuIsOpen) element.toggleMenu(false, false);
					});
				});
			}
		}
	}
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
// File#: _1_popover
// Usage: codyhouse.co/license
(function() {
  var Popover = function(element) {
    this.element = element;
		this.elementId = this.element.getAttribute('id');
		this.trigger = document.querySelectorAll('[aria-controls="'+this.elementId+'"]');
		this.selectedTrigger = false;
    this.popoverVisibleClass = 'popover--is-visible';
    this.selectedTriggerClass = 'popover-control--active';
    this.popoverIsOpen = false;
    // focusable elements
    this.firstFocusable = false;
		this.lastFocusable = false;
		// position target - position tooltip relative to a specified element
		this.positionTarget = getPositionTarget(this);
		// gap between element and viewport - if there's max-height 
		this.viewportGap = parseInt(getComputedStyle(this.element).getPropertyValue('--popover-viewport-gap')) || 20;
		initPopover(this);
		initPopoverEvents(this);
  };

  // public methods
  Popover.prototype.togglePopover = function(bool, moveFocus) {
    togglePopover(this, bool, moveFocus);
  };

  Popover.prototype.checkPopoverClick = function(target) {
    checkPopoverClick(this, target);
  };

  Popover.prototype.checkPopoverFocus = function() {
    checkPopoverFocus(this);
  };

	// private methods
	function getPositionTarget(popover) {
		// position tooltip relative to a specified element - if provided
		var positionTargetSelector = popover.element.getAttribute('data-position-target');
		if(!positionTargetSelector) return false;
		var positionTarget = document.querySelector(positionTargetSelector);
		return positionTarget;
	};

  function initPopover(popover) {
		// init aria-labels
		for(var i = 0; i < popover.trigger.length; i++) {
			Util.setAttributes(popover.trigger[i], {'aria-expanded': 'false', 'aria-haspopup': 'true'});
		}
  };
  
  function initPopoverEvents(popover) {
		for(var i = 0; i < popover.trigger.length; i++) {(function(i){
			popover.trigger[i].addEventListener('click', function(event){
				event.preventDefault();
				// if the popover had been previously opened by another trigger element -> close it first and reopen in the right position
				if(Util.hasClass(popover.element, popover.popoverVisibleClass) && popover.selectedTrigger !=  popover.trigger[i]) {
					togglePopover(popover, false, false); // close menu
				}
				// toggle popover
				popover.selectedTrigger = popover.trigger[i];
				togglePopover(popover, !Util.hasClass(popover.element, popover.popoverVisibleClass), true);
			});
    })(i);}
    
    // trap focus
    popover.element.addEventListener('keydown', function(event){
      if( event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' ) {
        //trap focus inside popover
        trapFocus(popover, event);
      }
    });
  };
  
  function togglePopover(popover, bool, moveFocus) {
		// toggle popover visibility
		Util.toggleClass(popover.element, popover.popoverVisibleClass, bool);
		popover.popoverIsOpen = bool;
		if(bool) {
      popover.selectedTrigger.setAttribute('aria-expanded', 'true');
      getFocusableElements(popover);
      // move focus
      focusPopover(popover);
			popover.element.addEventListener("transitionend", function(event) {focusPopover(popover);}, {once: true});
			// position the popover element
			positionPopover(popover);
			// add class to popover trigger
			Util.addClass(popover.selectedTrigger, popover.selectedTriggerClass);
		} else if(popover.selectedTrigger) {
			popover.selectedTrigger.setAttribute('aria-expanded', 'false');
			if(moveFocus) Util.moveFocus(popover.selectedTrigger);
			// remove class from menu trigger
			Util.removeClass(popover.selectedTrigger, popover.selectedTriggerClass);
			popover.selectedTrigger = false;
		}
	};
	
	function focusPopover(popover) {
		if(popover.firstFocusable) {
			popover.firstFocusable.focus();
		} else {
			Util.moveFocus(popover.element);
		}
	};

  function positionPopover(popover) {
		// reset popover position
		resetPopoverStyle(popover);
		var selectedTriggerPosition = (popover.positionTarget) ? popover.positionTarget.getBoundingClientRect() : popover.selectedTrigger.getBoundingClientRect();
		
		var menuOnTop = (window.innerHeight - selectedTriggerPosition.bottom) < selectedTriggerPosition.top;
			
		var left = selectedTriggerPosition.left,
			right = (window.innerWidth - selectedTriggerPosition.right),
			isRight = (window.innerWidth < selectedTriggerPosition.left + popover.element.offsetWidth);

		var horizontal = isRight ? 'right: '+right+'px;' : 'left: '+left+'px;',
			vertical = menuOnTop
				? 'bottom: '+(window.innerHeight - selectedTriggerPosition.top)+'px;'
				: 'top: '+selectedTriggerPosition.bottom+'px;';
		// check right position is correct -> otherwise set left to 0
		if( isRight && (right + popover.element.offsetWidth) > window.innerWidth) horizontal = 'left: '+ parseInt((window.innerWidth - popover.element.offsetWidth)/2)+'px;';
		// check if popover needs a max-height (user will scroll inside the popover)
		var maxHeight = menuOnTop ? selectedTriggerPosition.top - popover.viewportGap : window.innerHeight - selectedTriggerPosition.bottom - popover.viewportGap;

		var initialStyle = popover.element.getAttribute('style');
		if(!initialStyle) initialStyle = '';
		popover.element.setAttribute('style', initialStyle + horizontal + vertical +'max-height:'+Math.floor(maxHeight)+'px;');
	};
	
	function resetPopoverStyle(popover) {
		// remove popover inline style before appling new style
		popover.element.style.maxHeight = '';
		popover.element.style.top = '';
		popover.element.style.bottom = '';
		popover.element.style.left = '';
		popover.element.style.right = '';
	};

  function checkPopoverClick(popover, target) {
    // close popover when clicking outside it
    if(!popover.popoverIsOpen) return;
    if(!popover.element.contains(target) && !target.closest('[aria-controls="'+popover.elementId+'"]')) togglePopover(popover, false);
  };

  function checkPopoverFocus(popover) {
    // on Esc key -> close popover if open and move focus (if focus was inside popover)
    if(!popover.popoverIsOpen) return;
    var popoverParent = document.activeElement.closest('.js-popover');
    togglePopover(popover, false, popoverParent);
  };
  
  function getFocusableElements(popover) {
    //get all focusable elements inside the popover
		var allFocusable = popover.element.querySelectorAll(focusableElString);
		getFirstVisible(popover, allFocusable);
		getLastVisible(popover, allFocusable);
  };

  function getFirstVisible(popover, elements) {
		//get first visible focusable element inside the popover
		for(var i = 0; i < elements.length; i++) {
			if( isVisible(elements[i]) ) {
				popover.firstFocusable = elements[i];
				break;
			}
		}
	};

  function getLastVisible(popover, elements) {
		//get last visible focusable element inside the popover
		for(var i = elements.length - 1; i >= 0; i--) {
			if( isVisible(elements[i]) ) {
				popover.lastFocusable = elements[i];
				break;
			}
		}
  };

  function trapFocus(popover, event) {
    if( popover.firstFocusable == document.activeElement && event.shiftKey) {
			//on Shift+Tab -> focus last focusable element when focus moves out of popover
			event.preventDefault();
			popover.lastFocusable.focus();
		}
		if( popover.lastFocusable == document.activeElement && !event.shiftKey) {
			//on Tab -> focus first focusable element when focus moves out of popover
			event.preventDefault();
			popover.firstFocusable.focus();
		}
  };
  
  function isVisible(element) {
		// check if element is visible
		return element.offsetWidth || element.offsetHeight || element.getClientRects().length;
	};

  window.Popover = Popover;

  //initialize the Popover objects
  var popovers = document.getElementsByClassName('js-popover');
  // generic focusable elements string selector
	var focusableElString = '[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary';
	
	if( popovers.length > 0 ) {
		var popoversArray = [];
		var scrollingContainers = [];
		for( var i = 0; i < popovers.length; i++) {
			(function(i){
				popoversArray.push(new Popover(popovers[i]));
				var scrollableElement = popovers[i].getAttribute('data-scrollable-element');
				if(scrollableElement && !scrollingContainers.includes(scrollableElement)) scrollingContainers.push(scrollableElement);
			})(i);
		}

		// listen for key events
		window.addEventListener('keyup', function(event){
			if( event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape' ) {
        // close popover on 'Esc'
				popoversArray.forEach(function(element){
					element.checkPopoverFocus();
				});
			} 
		});
		// close popover when clicking outside it
		window.addEventListener('click', function(event){
			popoversArray.forEach(function(element){
				element.checkPopoverClick(event.target);
			});
		});
		// on resize -> close all popover elements
		window.addEventListener('resize', function(event){
			popoversArray.forEach(function(element){
				element.togglePopover(false, false);
			});
		});
		// on scroll -> close all popover elements
		window.addEventListener('scroll', function(event){
			popoversArray.forEach(function(element){
				if(element.popoverIsOpen) element.togglePopover(false, false);
			});
		});
		// take into account additinal scrollable containers
		for(var j = 0; j < scrollingContainers.length; j++) {
			var scrollingContainer = document.querySelector(scrollingContainers[j]);
			if(scrollingContainer) {
				scrollingContainer.addEventListener('scroll', function(event){
					popoversArray.forEach(function(element){
						if(element.popoverIsOpen) element.togglePopover(false, false);
					});
				});
			}
		}
	}
}());
// File#: _1_pre-header
// Usage: codyhouse.co/license
(function() {
	var preHeader = document.getElementsByClassName('js-pre-header');
	if(preHeader.length > 0) {
		for(var i = 0; i < preHeader.length; i++) {
			(function(i){ addPreHeaderEvent(preHeader[i]);})(i);
		}

		function addPreHeaderEvent(element) {
			var close = element.getElementsByClassName('js-pre-header__close-btn')[0];
			if(close) {
				close.addEventListener('click', function(event) {
					event.preventDefault();
					Util.addClass(element, 'pre-header--is-hidden');
				});
			}
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
			target.style.outline = 'none';
			!tabindex && target.removeAttribute('tabindex');
		}	
	};

	SmoothScroll.prototype.getFixedElementHeight = function() {
		var scrollElementY = this.dataElementY ? this.scrollElementY : document.documentElement;
    var fixedElementDelta = parseInt(getComputedStyle(scrollElementY).getPropertyValue('scroll-padding'));
		if(isNaN(fixedElementDelta) ) { // scroll-padding not supported
			fixedElementDelta = 0;
			var fixedElement = document.querySelector(this.element.getAttribute('data-fixed-element'));
			if(fixedElement) fixedElementDelta = parseInt(fixedElement.getBoundingClientRect().height);
		}
		return fixedElementDelta;
	};
	
	//initialize the Smooth Scroll objects
	var smoothScrollLinks = document.getElementsByClassName('js-smooth-scroll');
	if( smoothScrollLinks.length > 0 && !Util.cssSupports('scroll-behavior', 'smooth') && window.requestAnimationFrame) {
		// you need javascript only if css scroll-behavior is not supported
		for( var i = 0; i < smoothScrollLinks.length; i++) {
			(function(i){new SmoothScroll(smoothScrollLinks[i]);})(i);
		}
	}
}());
// File#: _1_social-sharing
// Usage: codyhouse.co/license
(function() {
  function initSocialShare(button) {
    button.addEventListener('click', function(event){
      event.preventDefault();
      var social = button.getAttribute('data-social');
      var url = getSocialUrl(button, social);
      (social == 'mail')
        ? window.location.href = url
        : window.open(url, social+'-share-dialog', 'width=626,height=436');
    });
  };

  function getSocialUrl(button, social) {
    var params = getSocialParams(social);
    var newUrl = '';
    for(var i = 0; i < params.length; i++) {
      var paramValue = button.getAttribute('data-'+params[i]);
      if(params[i] == 'hashtags') paramValue = encodeURI(paramValue.replace(/\#| /g, ''));
      if(paramValue) {
        (social == 'facebook') 
          ? newUrl = newUrl + 'u='+encodeURIComponent(paramValue)+'&'
          : newUrl = newUrl + params[i]+'='+encodeURIComponent(paramValue)+'&';
      }
    }
    if(social == 'linkedin') newUrl = 'mini=true&'+newUrl;
    return button.getAttribute('href')+'?'+newUrl;
  };

  function getSocialParams(social) {
    var params = [];
    switch (social) {
      case 'twitter':
        params = ['text', 'hashtags'];
        break;
      case 'facebook':
      case 'linkedin':
        params = ['url'];
        break;
      case 'pinterest':
        params = ['url', 'media', 'description'];
        break;
      case 'mail':
        params = ['subject', 'body'];
        break;
    }
    return params;
  };

  var socialShare = document.getElementsByClassName('js-social-share');
  if(socialShare.length > 0) {
    for( var i = 0; i < socialShare.length; i++) {
      (function(i){initSocialShare(socialShare[i])})(i);
    }
  }
}());
// File#: _1_swipe-content
(function() {
	var SwipeContent = function(element) {
		this.element = element;
		this.delta = [false, false];
		this.dragging = false;
		this.intervalId = false;
		initSwipeContent(this);
	};

	function initSwipeContent(content) {
		content.element.addEventListener('mousedown', handleEvent.bind(content));
		content.element.addEventListener('touchstart', handleEvent.bind(content));
	};

	function initDragging(content) {
		//add event listeners
		content.element.addEventListener('mousemove', handleEvent.bind(content));
		content.element.addEventListener('touchmove', handleEvent.bind(content));
		content.element.addEventListener('mouseup', handleEvent.bind(content));
		content.element.addEventListener('mouseleave', handleEvent.bind(content));
		content.element.addEventListener('touchend', handleEvent.bind(content));
	};

	function cancelDragging(content) {
		//remove event listeners
		if(content.intervalId) {
			(!window.requestAnimationFrame) ? clearInterval(content.intervalId) : window.cancelAnimationFrame(content.intervalId);
			content.intervalId = false;
		}
		content.element.removeEventListener('mousemove', handleEvent.bind(content));
		content.element.removeEventListener('touchmove', handleEvent.bind(content));
		content.element.removeEventListener('mouseup', handleEvent.bind(content));
		content.element.removeEventListener('mouseleave', handleEvent.bind(content));
		content.element.removeEventListener('touchend', handleEvent.bind(content));
	};

	function handleEvent(event) {
		switch(event.type) {
			case 'mousedown':
			case 'touchstart':
				startDrag(this, event);
				break;
			case 'mousemove':
			case 'touchmove':
				drag(this, event);
				break;
			case 'mouseup':
			case 'mouseleave':
			case 'touchend':
				endDrag(this, event);
				break;
		}
	};

	function startDrag(content, event) {
		content.dragging = true;
		// listen to drag movements
		initDragging(content);
		content.delta = [parseInt(unify(event).clientX), parseInt(unify(event).clientY)];
		// emit drag start event
		emitSwipeEvents(content, 'dragStart', content.delta, event.target);
	};

	function endDrag(content, event) {
		cancelDragging(content);
		// credits: https://css-tricks.com/simple-swipe-with-vanilla-javascript/
		var dx = parseInt(unify(event).clientX), 
	    dy = parseInt(unify(event).clientY);
	  
	  // check if there was a left/right swipe
		if(content.delta && (content.delta[0] || content.delta[0] === 0)) {
	    var s = getSign(dx - content.delta[0]);
			
			if(Math.abs(dx - content.delta[0]) > 30) {
				(s < 0) ? emitSwipeEvents(content, 'swipeLeft', [dx, dy]) : emitSwipeEvents(content, 'swipeRight', [dx, dy]);	
			}
	    
	    content.delta[0] = false;
	  }
		// check if there was a top/bottom swipe
	  if(content.delta && (content.delta[1] || content.delta[1] === 0)) {
	  	var y = getSign(dy - content.delta[1]);

	  	if(Math.abs(dy - content.delta[1]) > 30) {
	    	(y < 0) ? emitSwipeEvents(content, 'swipeUp', [dx, dy]) : emitSwipeEvents(content, 'swipeDown', [dx, dy]);
	    }

	    content.delta[1] = false;
	  }
		// emit drag end event
	  emitSwipeEvents(content, 'dragEnd', [dx, dy]);
	  content.dragging = false;
	};

	function drag(content, event) {
		if(!content.dragging) return;
		// emit dragging event with coordinates
		(!window.requestAnimationFrame) 
			? content.intervalId = setTimeout(function(){emitDrag.bind(content, event);}, 250) 
			: content.intervalId = window.requestAnimationFrame(emitDrag.bind(content, event));
	};

	function emitDrag(event) {
		emitSwipeEvents(this, 'dragging', [parseInt(unify(event).clientX), parseInt(unify(event).clientY)]);
	};

	function unify(event) { 
		// unify mouse and touch events
		return event.changedTouches ? event.changedTouches[0] : event; 
	};

	function emitSwipeEvents(content, eventName, detail, el) {
		var trigger = false;
		if(el) trigger = el;
		// emit event with coordinates
		var event = new CustomEvent(eventName, {detail: {x: detail[0], y: detail[1], origin: trigger}});
		content.element.dispatchEvent(event);
	};

	function getSign(x) {
		if(!Math.sign) {
			return ((x > 0) - (x < 0)) || +x;
		} else {
			return Math.sign(x);
		}
	};

	window.SwipeContent = SwipeContent;
	
	//initialize the SwipeContent objects
	var swipe = document.getElementsByClassName('js-swipe-content');
	if( swipe.length > 0 ) {
		for( var i = 0; i < swipe.length; i++) {
			(function(i){new SwipeContent(swipe[i]);})(i);
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
// File#: _1_toast
// Usage: codyhouse.co/license
(function() {
  var Toasts = function() {
    this.toastsEl = document.getElementsByClassName('js-toast');
    this.toastsId = getRandomInt(0, 1000);
    this.index = 0;
    this.closingToast = false;
    initToasts(this);
  };

  // public method to initialize new toast elements
  Toasts.prototype.initToast = function(element) {
		initSingleToast(this, element);
	};

  function initToasts(obj) {
    // create a wrapper element for each toast variation
    createWrapper(obj, 'top-right');
    createWrapper(obj, 'top-left');
    createWrapper(obj, 'top-center');
    createWrapper(obj, 'bottom-right');
    createWrapper(obj, 'bottom-left');
    createWrapper(obj, 'bottom-center');

    // init single toast element
    for(var i = 0; i < obj.toastsEl.length; i++) {
      initSingleToast(obj, obj.toastsEl[i]);
    }

    // listen for dynamic toast creation
    window.addEventListener('newToast', function(event) {
      initSingleToast(obj, event.detail);
    });
  };

  function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); 
  };

  function createWrapper(obj, position) {
    var classes = 'top-0 left-0 flex-column';
    if(position == 'top-right') classes = 'top-0 right-0 flex-column';
    if(position == 'top-center') classes = 'top-0 left-50% -translate-x-50% flex-column items-center';
    if(position == 'bottom-right') classes = 'bottom-0 right-0 flex-column-reverse';
    if(position == 'bottom-left') classes = 'bottom-0 left-0 flex-column-reverse';
    if(position == 'bottom-center') classes = 'bottom-0 left-50% -translate-x-50% flex-column-reverse items-center';

    var div = '<div class="toast-wrapper position-fixed flex '+classes+'" id="toast-wrapper-'+position+'"></div>';
    document.body.insertAdjacentHTML('beforeend', div);
    obj[position] = document.getElementById('toast-wrapper-'+position);
  };

  function initSingleToast(obj, toast) {
    var id = 'toast-'+obj.toastsId+'-'+obj.index;
    obj.index = obj.index + 1;
    // store toast info in the Toasts obj
    obj[id] = {};
    obj[id]['interval'] = toast.getAttribute('data-toast-interval') || 5000,
    obj[id]['intervalId'] = false;
    obj[id]['closing'] = false;
    // get position type
    var classes = toast.getAttribute('class');
    obj[id]['position'] = 'top-right';
    if(classes.indexOf('toast--top-left') > -1) obj[id]['position'] = 'top-left';
    if(classes.indexOf('toast--top-center') > -1) obj[id]['position'] = 'top-center';
    if(classes.indexOf('toast--bottom-right') > -1) obj[id]['position'] = 'bottom-right';
    if(classes.indexOf('toast--bottom-left') > -1) obj[id]['position'] = 'bottom-left'; 
    if(classes.indexOf('toast--bottom-center') > -1) obj[id]['position'] = 'bottom-center';

    // listen for custom open event
    toast.addEventListener('openToast', function() {
      if(!Util.hasClass(toast, 'toast--hidden') || obj[id]['closing']) return;
      openToast(obj, toast, id);
    });

    // close toast
    toast.addEventListener('click', function(event){
      if(event.target.closest('.js-toast__close-btn')) {
        obj.closingToast = true;
        closeToast(obj, toast, id);
      }
    });
  };

  function openToast(obj, toast, id) {
    if(obj[id]['intervalId']) {
      clearInterval(obj[id]['intervalId']);
      obj[id]['intervalId'] = false;
    }
    // place toast - insert in the proper container
    var fragment = document.createDocumentFragment();
    fragment.appendChild(toast);
    obj[obj[id]['position']].appendChild(fragment);

    // change position
    toast.style.position = 'static';

    // show toast
    setTimeout(function() {
      Util.removeClass(toast, 'toast--hidden');
    });
    
    // automatically close after a time interval
    if(obj[id]['interval'] && parseInt(obj[id]['interval']) > 0) {
      setToastInterval(obj, toast, id, obj[id]['interval']);
    }
  };

  function setToastInterval(obj, toast, id, interval) {
    obj[id]['intervalId'] = setTimeout(function(){
      if(obj.closingToast) return setToastInterval(obj, toast, id, 1000);
      closeToast(obj, toast, id);
    }, interval);
  };

  function closeToast(obj, toast, id) {
    obj[id]['closing'] = true;
    Util.addClass(toast, 'toast--hidden');
    // clear timeout
    if(obj[id]['intervalId']) clearTimeout(obj[id]['intervalId']);
    // remove toast and animate siblings
    closeToastAnimation(obj, toast, id);    
  };

  function closeToastAnimation(obj, toast, id) {
    // get all next elements 
    var siblings = getToastNextSiblings(toast);
    // get translate value (could be positive or negative based on position)
    var toastStyle = window.getComputedStyle(toast),
      margin = parseInt(toastStyle.getPropertyValue('margin-top')) || parseInt(toastStyle.getPropertyValue('margin-bottom'));
    // translate next elements if any
    var translate = toast.offsetHeight + margin;
    if(obj[id]['position'].indexOf('top') > -1) {
      translate = '-'+translate
    }
    for(var i = 0; i < siblings.length; i++) {
      siblings[i].style.transform = 'translateY('+translate+'px)';
    }
    // remove toast and reset translate
    toast.addEventListener('transitionend', function cb(event){
      if(event.propertyName != 'opacity') return;
      toast.removeEventListener('transitionend', cb);
      removeToast(toast, siblings, obj, id);
      obj.closingToast = false;
    });
  };

  function getToastNextSiblings(toast) {
    var array = [];
    var nextSibling = toast.nextElementSibling;
    if(nextSibling) {
      array.push(nextSibling);
      var nextSiblingsIterate = getToastNextSiblings(nextSibling);
      Array.prototype.push.apply(array, nextSiblingsIterate);
    }
    return array;
  };

  function removeToast(toast, siblings, obj, id) {
    // reset position
    toast.style.position = '';

    // move toast back to body
    var fragment = document.createDocumentFragment();
    fragment.appendChild(toast);
    document.body.appendChild(fragment); 

    // reset siblings translate
    for(var i = 0; i < siblings.length; i++) {
      (function(i){
        // set transition to none
        siblings[i].style.transition = 'none';
        siblings[i].style.transform = '';
        setTimeout(function() {siblings[i].style.transition = '';}, 10);
      })(i);
    }

    // reset closing status
    obj[id]['closing'] = false;
  };

  window.Toasts = Toasts;

	//initialize the Toasts objects
	var toasts = document.getElementsByClassName('js-toast');
	if( toasts.length > 0 ) {
		new Toasts();
	}
}());
// File#: _1_tooltip
// Usage: codyhouse.co/license
(function() {
	var Tooltip = function(element) {
		this.element = element;
		this.tooltip = false;
		this.tooltipIntervalId = false;
		this.tooltipContent = this.element.getAttribute('title');
		this.tooltipPosition = (this.element.getAttribute('data-tooltip-position')) ? this.element.getAttribute('data-tooltip-position') : 'top';
		this.tooltipClasses = (this.element.getAttribute('data-tooltip-class')) ? this.element.getAttribute('data-tooltip-class') : false;
		this.tooltipId = 'js-tooltip-element'; // id of the tooltip element -> trigger will have the same aria-describedby attr
		// there are cases where you only need the aria-label -> SR do not need to read the tooltip content (e.g., footnotes)
		this.tooltipDescription = (this.element.getAttribute('data-tooltip-describedby') && this.element.getAttribute('data-tooltip-describedby') == 'false') ? false : true; 

		this.tooltipDelay = 300; // show tooltip after a delay (in ms)
		this.tooltipDelta = 10; // distance beetwen tooltip and trigger element (in px)
		this.tooltipTriggerHover = false;
		// tooltp sticky option
		this.tooltipSticky = (this.tooltipClasses && this.tooltipClasses.indexOf('tooltip--sticky') > -1);
		this.tooltipHover = false;
		if(this.tooltipSticky) {
			this.tooltipHoverInterval = false;
		}
		resetTooltipContent(this);
		initTooltip(this);
	};

	function resetTooltipContent(tooltip) {
		var htmlContent = tooltip.element.getAttribute('data-tooltip-title');
		if(htmlContent) {
			tooltip.tooltipContent = htmlContent;
		}
	};

	function initTooltip(tooltipObj) {
		// reset trigger element
		tooltipObj.element.removeAttribute('title');
		tooltipObj.element.setAttribute('tabindex', '0');
		// add event listeners
		tooltipObj.element.addEventListener('mouseenter', handleEvent.bind(tooltipObj));
		tooltipObj.element.addEventListener('focus', handleEvent.bind(tooltipObj));
	};

	function removeTooltipEvents(tooltipObj) {
		// remove event listeners
		tooltipObj.element.removeEventListener('mouseleave',  handleEvent.bind(tooltipObj));
		tooltipObj.element.removeEventListener('blur',  handleEvent.bind(tooltipObj));
	};

	function handleEvent(event) {
		// handle events
		switch(event.type) {
			case 'mouseenter':
			case 'focus':
				showTooltip(this, event);
				break;
			case 'mouseleave':
			case 'blur':
				checkTooltip(this);
				break;
		}
	};

	function showTooltip(tooltipObj, event) {
		// tooltip has already been triggered
		if(tooltipObj.tooltipIntervalId) return;
		tooltipObj.tooltipTriggerHover = true;
		// listen to close events
		tooltipObj.element.addEventListener('mouseleave', handleEvent.bind(tooltipObj));
		tooltipObj.element.addEventListener('blur', handleEvent.bind(tooltipObj));
		// show tooltip with a delay
		tooltipObj.tooltipIntervalId = setTimeout(function(){
			createTooltip(tooltipObj);
		}, tooltipObj.tooltipDelay);
	};

	function createTooltip(tooltipObj) {
		tooltipObj.tooltip = document.getElementById(tooltipObj.tooltipId);
		
		if( !tooltipObj.tooltip ) { // tooltip element does not yet exist
			tooltipObj.tooltip = document.createElement('div');
			document.body.appendChild(tooltipObj.tooltip);
		} 
		
		// reset tooltip content/position
		Util.setAttributes(tooltipObj.tooltip, {'id': tooltipObj.tooltipId, 'class': 'tooltip tooltip--is-hidden js-tooltip', 'role': 'tooltip'});
		tooltipObj.tooltip.innerHTML = tooltipObj.tooltipContent;
		if(tooltipObj.tooltipDescription) tooltipObj.element.setAttribute('aria-describedby', tooltipObj.tooltipId);
		if(tooltipObj.tooltipClasses) Util.addClass(tooltipObj.tooltip, tooltipObj.tooltipClasses);
		if(tooltipObj.tooltipSticky) Util.addClass(tooltipObj.tooltip, 'tooltip--sticky');
		placeTooltip(tooltipObj);
		Util.removeClass(tooltipObj.tooltip, 'tooltip--is-hidden');

		// if tooltip is sticky, listen to mouse events
		if(!tooltipObj.tooltipSticky) return;
		tooltipObj.tooltip.addEventListener('mouseenter', function cb(){
			tooltipObj.tooltipHover = true;
			if(tooltipObj.tooltipHoverInterval) {
				clearInterval(tooltipObj.tooltipHoverInterval);
				tooltipObj.tooltipHoverInterval = false;
			}
			tooltipObj.tooltip.removeEventListener('mouseenter', cb);
			tooltipLeaveEvent(tooltipObj);
		});
	};

	function tooltipLeaveEvent(tooltipObj) {
		tooltipObj.tooltip.addEventListener('mouseleave', function cb(){
			tooltipObj.tooltipHover = false;
			tooltipObj.tooltip.removeEventListener('mouseleave', cb);
			hideTooltip(tooltipObj);
		});
	};

	function placeTooltip(tooltipObj) {
		// set top and left position of the tooltip according to the data-tooltip-position attr of the trigger
		var dimention = [tooltipObj.tooltip.offsetHeight, tooltipObj.tooltip.offsetWidth],
			positionTrigger = tooltipObj.element.getBoundingClientRect(),
			position = [],
			scrollY = window.scrollY || window.pageYOffset;
		
		position['top'] = [ (positionTrigger.top - dimention[0] - tooltipObj.tooltipDelta + scrollY), (positionTrigger.right/2 + positionTrigger.left/2 - dimention[1]/2)];
		position['bottom'] = [ (positionTrigger.bottom + tooltipObj.tooltipDelta + scrollY), (positionTrigger.right/2 + positionTrigger.left/2 - dimention[1]/2)];
		position['left'] = [(positionTrigger.top/2 + positionTrigger.bottom/2 - dimention[0]/2 + scrollY), positionTrigger.left - dimention[1] - tooltipObj.tooltipDelta];
		position['right'] = [(positionTrigger.top/2 + positionTrigger.bottom/2 - dimention[0]/2 + scrollY), positionTrigger.right + tooltipObj.tooltipDelta];
		
		var direction = tooltipObj.tooltipPosition;
		if( direction == 'top' && position['top'][0] < scrollY) direction = 'bottom';
		else if( direction == 'bottom' && position['bottom'][0] + tooltipObj.tooltipDelta + dimention[0] > scrollY + window.innerHeight) direction = 'top';
		else if( direction == 'left' && position['left'][1] < 0 )  direction = 'right';
		else if( direction == 'right' && position['right'][1] + dimention[1] > window.innerWidth ) direction = 'left';
		
		if(direction == 'top' || direction == 'bottom') {
			if(position[direction][1] < 0 ) position[direction][1] = 0;
			if(position[direction][1] + dimention[1] > window.innerWidth ) position[direction][1] = window.innerWidth - dimention[1];
		}
		tooltipObj.tooltip.style.top = position[direction][0]+'px';
		tooltipObj.tooltip.style.left = position[direction][1]+'px';
		Util.addClass(tooltipObj.tooltip, 'tooltip--'+direction);
	};

	function checkTooltip(tooltipObj) {
		tooltipObj.tooltipTriggerHover = false;
		if(!tooltipObj.tooltipSticky) hideTooltip(tooltipObj);
		else {
			if(tooltipObj.tooltipHover) return;
			if(tooltipObj.tooltipHoverInterval) return;
			tooltipObj.tooltipHoverInterval = setTimeout(function(){
				hideTooltip(tooltipObj); 
				tooltipObj.tooltipHoverInterval = false;
			}, 300);
		}
	};

	function hideTooltip(tooltipObj) {
		if(tooltipObj.tooltipHover || tooltipObj.tooltipTriggerHover) return;
		clearInterval(tooltipObj.tooltipIntervalId);
		if(tooltipObj.tooltipHoverInterval) {
			clearInterval(tooltipObj.tooltipHoverInterval);
			tooltipObj.tooltipHoverInterval = false;
		}
		tooltipObj.tooltipIntervalId = false;
		if(!tooltipObj.tooltip) return;
		// hide tooltip
		removeTooltip(tooltipObj);
		// remove events
		removeTooltipEvents(tooltipObj);
	};

	function removeTooltip(tooltipObj) {
		Util.addClass(tooltipObj.tooltip, 'tooltip--is-hidden');
		if(tooltipObj.tooltipDescription) tooltipObj.element.removeAttribute('aria-describedby');
	};

	window.Tooltip = Tooltip;

	//initialize the Tooltip objects
	var tooltips = document.getElementsByClassName('js-tooltip-trigger');
	if( tooltips.length > 0 ) {
		for( var i = 0; i < tooltips.length; i++) {
			(function(i){new Tooltip(tooltips[i]);})(i);
		}
	}
}());
// File#: _2_adv-custom-select
// Usage: codyhouse.co/license
(function() {
  var AdvSelect = function(element) {
    this.element = element;
    this.select = this.element.getElementsByTagName('select')[0];
    this.optGroups = this.select.getElementsByTagName('optgroup');
    this.options = this.select.getElementsByTagName('option');
    this.optionData = getOptionsData(this);
    this.selectId = this.select.getAttribute('id');
    this.selectLabel = document.querySelector('[for='+this.selectId+']')
    this.trigger = this.element.getElementsByClassName('js-adv-select__control')[0];
    this.triggerLabel = this.trigger.getElementsByClassName('js-adv-select__value')[0];
    this.dropdown = document.getElementById(this.trigger.getAttribute('aria-controls'));

    initAdvSelect(this); // init markup
    initAdvSelectEvents(this); // init event listeners
  };

  function getOptionsData(select) {
    var obj = [],
      dataset = select.options[0].dataset;

    function camelCaseToDash( myStr ) {
      return myStr.replace( /([a-z])([A-Z])/g, '$1-$2' ).toLowerCase();
    }
    for (var prop in dataset) {
      if (Object.prototype.hasOwnProperty.call(dataset, prop)) {
        // obj[prop] = select.dataset[prop];
        obj.push(camelCaseToDash(prop));
      }
    }
    return obj;
  };

  function initAdvSelect(select) {
    // create custom structure
    createAdvStructure(select);
    // update trigger label
    updateTriggerLabel(select);
    // hide native select and show custom structure
    Util.addClass(select.select, 'is-hidden');
    Util.removeClass(select.trigger, 'is-hidden');
    Util.removeClass(select.dropdown, 'is-hidden');
  };

  function initAdvSelectEvents(select) {
    if(select.selectLabel) {
      // move focus to custom trigger when clicking on <select> label
      select.selectLabel.addEventListener('click', function(){
        select.trigger.focus();
      });
    }

    // option is selected in dropdown
    select.dropdown.addEventListener('click', function(event){
      triggerSelection(select, event.target);
    });

    // keyboard navigation
    select.dropdown.addEventListener('keydown', function(event){
      if(event.keyCode && event.keyCode == 38 || event.key && event.key.toLowerCase() == 'arrowup') {
        keyboardCustomSelect(select, 'prev', event);
      } else if(event.keyCode && event.keyCode == 40 || event.key && event.key.toLowerCase() == 'arrowdown') {
        keyboardCustomSelect(select, 'next', event);
      } else if(event.keyCode && event.keyCode == 13 || event.key && event.key.toLowerCase() == 'enter') {
        triggerSelection(select, document.activeElement);
      }
    });
  };

  function createAdvStructure(select) {
    // store optgroup and option structure
    var optgroup = select.dropdown.querySelector('[role="group"]'),
      option = select.dropdown.querySelector('[role="option"]'),
      optgroupClone = false,
      optgroupLabel = false,
      optionClone = false;
    if(optgroup) {
      optgroupClone = optgroup.cloneNode();
      optgroupLabel = document.getElementById(optgroupClone.getAttribute('describedby'));
    }
    if(option) optionClone = option.cloneNode(true);

    var dropdownCode = '';

    if(select.optGroups.length > 0) {
      for(var i = 0; i < select.optGroups.length; i++) {
        dropdownCode = dropdownCode + getOptGroupCode(select, select.optGroups[i], optgroupClone, optionClone, optgroupLabel, i);
      }
    } else {
      for(var i = 0; i < select.options.length; i++) {
        dropdownCode = dropdownCode + getOptionCode(select, select.options[i], optionClone);
      }
    }

    select.dropdown.innerHTML = dropdownCode;
  };

  function getOptGroupCode(select, optGroup, optGroupClone, optionClone, optgroupLabel, index) {
    if(!optGroupClone || !optionClone) return '';
    var code = '';
    var options = optGroup.getElementsByTagName('option');
    for(var i = 0; i < options.length; i++) {
      code = code + getOptionCode(select, options[i], optionClone);
    }
    if(optgroupLabel) {
      var label = optgroupLabel.cloneNode(true);
      var id = label.getAttribute('id') + '-'+index;
      label.setAttribute('id', id);
      optGroupClone.setAttribute('describedby', id);
      code = label.outerHTML.replace('{optgroup-label}', optGroup.getAttribute('label')) + code;
    } 
    optGroupClone.innerHTML = code;
    return optGroupClone.outerHTML;
  };

  function getOptionCode(select, option, optionClone) {
    optionClone.setAttribute('data-value', option.value);
    if(option.selected) {
      optionClone.setAttribute('aria-selected', 'true');
      optionClone.setAttribute('tabindex', '0');
    } else {
      optionClone.removeAttribute('aria-selected');
      optionClone.removeAttribute('tabindex');
    }
    var optionHtml = optionClone.outerHTML;
    optionHtml = optionHtml.replace('{option-label}', option.text);
    for(var i = 0; i < select.optionData.length; i++) {
      optionHtml = optionHtml.replace('{'+select.optionData[i]+'}', option.getAttribute('data-'+select.optionData[i]));
    }
    return optionHtml;
  };

  function updateTriggerLabel(select) {
    // select.triggerLabel.textContent = select.options[select.select.selectedIndex].text;
    select.triggerLabel.innerHTML = select.dropdown.querySelector('[aria-selected="true"]').innerHTML;
  };

  function triggerSelection(select, target) {
    var option = target.closest('[role="option"]');
    if(!option) return;
    selectOption(select, option);
  };

  function selectOption(select, option) {
    if(option.hasAttribute('aria-selected') && option.getAttribute('aria-selected') == 'true') {
      // selecting the same option
    } else { 
      var selectedOption = select.dropdown.querySelector('[aria-selected="true"]');
      if(selectedOption) {
        selectedOption.removeAttribute('aria-selected');
        selectedOption.removeAttribute('tabindex');
      }
      option.setAttribute('aria-selected', 'true');
      option.setAttribute('tabindex', '0');
      // new option has been selected -> update native <select> element and trigger label
      updateNativeSelect(select, option.getAttribute('data-value'));
      updateTriggerLabel(select);
    }
    // move focus back to trigger
    setTimeout(function(){
      select.trigger.click();
    });
  };

  function updateNativeSelect(select, selectedValue) {
    var selectedOption = select.select.querySelector('[value="'+selectedValue+'"');
    select.select.selectedIndex = Util.getIndexInArray(select.options, selectedOption);
    select.select.dispatchEvent(new CustomEvent('change', {bubbles: true})); // trigger change event
  };

  function keyboardCustomSelect(select, direction) {
    var selectedOption = select.select.querySelector('[value="'+document.activeElement.getAttribute('data-value')+'"]');
    if(!selectedOption) return;
    var index = Util.getIndexInArray(select.options, selectedOption);
    
    index = direction == 'next' ? index + 1 : index - 1;
    if(index < 0) return;
    if(index >= select.options.length) return;
    
    var dropdownOption = select.dropdown.querySelector('[data-value="'+select.options[index].getAttribute('value')+'"]');
    if(dropdownOption) Util.moveFocus(dropdownOption);
  };

  //initialize the AdvSelect objects
  var advSelect = document.getElementsByClassName('js-adv-select');
  if( advSelect.length > 0 ) {
    for( var i = 0; i < advSelect.length; i++) {
      (function(i){new AdvSelect(advSelect[i]);})(i);
    }
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
// File#: _2_checkout-v2
// Usage: codyhouse.co/license
(function() {
  // update billing info visibility
  var billingCheckBox = document.getElementsByClassName('js-billing-checkbox');
  if(billingCheckBox.length > 0) {
    var billingInfo = document.getElementsByClassName('js-billing-info');
    if(billingInfo.length == 0) return;
    resetBillingInfo(billingCheckBox[0], billingInfo[0]);
    
    billingCheckBox[0].addEventListener('change', function(){
      resetBillingInfo(billingCheckBox[0], billingInfo[0]);
    });
  }

  function resetBillingInfo(input, content) {
    Util.toggleClass(content, 'is-visible', !input.checked);
  };
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
// File#: _2_footnotes
// Usage: codyhouse.co/license
(function() {
	var Footnote = function(element) {
		this.element = element;
		this.link = this.element.getElementsByClassName('footnotes__back-link')[0];
		this.contentLink = document.getElementById(this.link.getAttribute('href').replace('#', ''));
		this.initFootnote();
	};

	Footnote.prototype.initFootnote = function() {
		Util.setAttributes(this.contentLink, {
			'aria-label': 'Footnote: '+this.element.getElementsByClassName('js-footnote__label')[0].textContent,
			'data-tooltip-class': 'tooltip--lg tooltip--sticky',
			'data-tooltip-describedby': 'false',
			'title': this.getFootnoteContent(),
		});
		new Tooltip(this.contentLink);
	};

	Footnote.prototype.getFootnoteContent = function() {
		var clone = this.element.cloneNode(true);
		clone.removeChild(clone.getElementsByClassName('footnotes__back-link')[0]);
		return clone.innerHTML;
	};

	//initialize the Footnote objects
	var footnotes = document.getElementsByClassName('js-footnotes__item');
	if( footnotes.length > 0 ) {
		for( var i = 0; i < footnotes.length; i++) {
			(function(i){new Footnote(footnotes[i]);})(i);
		}
	}
}());
// File#: _2_points-of-interest
// Usage: codyhouse.co/license
(function() {
  function initPoi(element) {
    element.addEventListener('click', function(event){
      var poiItem = event.target.closest('.js-poi__item');
      if(poiItem) Util.addClass(poiItem, 'poi__item--visited');
    });
  };

  var poi = document.getElementsByClassName('js-poi');
  for(var i = 0; i < poi.length; i++) {
    (function(i){initPoi(poi[i]);})(i);
  }
}());
// File#: _2_menu-bar
// Usage: codyhouse.co/license
(function() {
  var MenuBar = function(element) {
    this.element = element;
    this.items = Util.getChildrenByClassName(this.element, 'menu-bar__item');
    this.mobHideItems = this.element.getElementsByClassName('menu-bar__item--hide');
    this.moreItemsTrigger = this.element.getElementsByClassName('js-menu-bar__trigger');
    initMenuBar(this);
  };

  function initMenuBar(menu) {
    setMenuTabIndex(menu); // set correct tabindexes for menu item
    initMenuBarMarkup(menu); // create additional markup
    checkMenuLayout(menu); // set menu layout
    Util.addClass(menu.element, 'menu-bar--loaded'); // reveal menu

    // custom event emitted when window is resized
    menu.element.addEventListener('update-menu-bar', function(event){
      checkMenuLayout(menu);
      if(menu.menuInstance) menu.menuInstance.toggleMenu(false, false); // close dropdown
    });

    // keyboard events 
    // open dropdown when pressing Enter on trigger element
    if(menu.moreItemsTrigger.length > 0) {
      menu.moreItemsTrigger[0].addEventListener('keydown', function(event) {
        if( (event.keyCode && event.keyCode == 13) || (event.key && event.key.toLowerCase() == 'enter') ) {
          if(!menu.menuInstance) return;
          menu.menuInstance.selectedTrigger = menu.moreItemsTrigger[0];
          menu.menuInstance.toggleMenu(!Util.hasClass(menu.subMenu, 'menu--is-visible'), true);
        }
      });

      // close dropdown on esc
      menu.subMenu.addEventListener('keydown', function(event) {
        if((event.keyCode && event.keyCode == 27) || (event.key && event.key.toLowerCase() == 'escape')) { // close submenu on esc
          if(menu.menuInstance) menu.menuInstance.toggleMenu(false, true);
        }
      });
    }
    
    // navigate menu items using left/right arrows
    menu.element.addEventListener('keydown', function(event) {
      if( (event.keyCode && event.keyCode == 39) || (event.key && event.key.toLowerCase() == 'arrowright') ) {
        navigateItems(menu.items, event, 'next');
      } else if( (event.keyCode && event.keyCode == 37) || (event.key && event.key.toLowerCase() == 'arrowleft') ) {
        navigateItems(menu.items, event, 'prev');
      }
    });
  };

  function setMenuTabIndex(menu) { // set tabindexes for the menu items to allow keyboard navigation
    var nextItem = false;
    for(var i = 0; i < menu.items.length; i++ ) {
      if(i == 0 || nextItem) menu.items[i].setAttribute('tabindex', '0');
      else menu.items[i].setAttribute('tabindex', '-1');
      if(i == 0 && menu.moreItemsTrigger.length > 0) nextItem = true;
      else nextItem = false;
    }
  };

  function initMenuBarMarkup(menu) {
    if(menu.mobHideItems.length == 0 ) { // no items to hide on mobile - remove trigger
      if(menu.moreItemsTrigger.length > 0) menu.element.removeChild(menu.moreItemsTrigger[0]);
      return;
    }

    if(menu.moreItemsTrigger.length == 0) return;

    // create the markup for the Menu element
    var content = '';
    menu.menuControlId = 'submenu-bar-'+Date.now();
    for(var i = 0; i < menu.mobHideItems.length; i++) {
      var item = menu.mobHideItems[i].cloneNode(true),
        svg = item.getElementsByTagName('svg')[0],
        label = item.getElementsByClassName('menu-bar__label')[0];

      svg.setAttribute('class', 'icon menu__icon');
      content = content + '<li role="menuitem"><span class="menu__content js-menu__content">'+svg.outerHTML+'<span>'+label.innerHTML+'</span></span></li>';
    }

    Util.setAttributes(menu.moreItemsTrigger[0], {'role': 'button', 'aria-expanded': 'false', 'aria-controls': menu.menuControlId, 'aria-haspopup': 'true'});

    var subMenu = document.createElement('menu'),
      customClass = menu.element.getAttribute('data-menu-class');
    Util.setAttributes(subMenu, {'id': menu.menuControlId, 'class': 'menu js-menu '+customClass});
    subMenu.innerHTML = content;
    document.body.appendChild(subMenu);

    menu.subMenu = subMenu;
    menu.subItems = subMenu.getElementsByTagName('li');

    menu.menuInstance = new Menu(menu.subMenu); // this will handle the dropdown behaviour
  };

  function checkMenuLayout(menu) { // switch from compressed to expanded layout and viceversa
    var layout = getComputedStyle(menu.element, ':before').getPropertyValue('content').replace(/\'|"/g, '');
    Util.toggleClass(menu.element, 'menu-bar--collapsed', layout == 'collapsed');
  };

  function navigateItems(list, event, direction, prevIndex) { // keyboard navigation among menu items
    event.preventDefault();
    var index = (typeof prevIndex !== 'undefined') ? prevIndex : Util.getIndexInArray(list, event.target),
      nextIndex = direction == 'next' ? index + 1 : index - 1;
    if(nextIndex < 0) nextIndex = list.length - 1;
    if(nextIndex > list.length - 1) nextIndex = 0;
    // check if element is visible before moving focus
    (list[nextIndex].offsetParent === null) ? navigateItems(list, event, direction, nextIndex) : Util.moveFocus(list[nextIndex]);
  };

  function checkMenuClick(menu, target) { // close dropdown when clicking outside the menu element
    if(menu.menuInstance && !menu.moreItemsTrigger[0].contains(target) && !menu.subMenu.contains(target)) menu.menuInstance.toggleMenu(false, false);
  };

  // init MenuBars objects
  var menuBars = document.getElementsByClassName('js-menu-bar');
  if( menuBars.length > 0 ) {
    var j = 0,
      menuBarArray = [];
    for( var i = 0; i < menuBars.length; i++) {
      var beforeContent = getComputedStyle(menuBars[i], ':before').getPropertyValue('content');
      if(beforeContent && beforeContent !='' && beforeContent !='none') {
        (function(i){menuBarArray.push(new MenuBar(menuBars[i]));})(i);
        j = j + 1;
      }
    }
    
    if(j > 0) {
      var resizingId = false,
        customEvent = new CustomEvent('update-menu-bar');
      // update Menu Bar layout on resize  
      window.addEventListener('resize', function(event){
        clearTimeout(resizingId);
        resizingId = setTimeout(doneResizing, 150);
      });

      // close menu when clicking outside it
      window.addEventListener('click', function(event){
        menuBarArray.forEach(function(element){
          checkMenuClick(element, event.target);
        });
      });

      function doneResizing() {
        for( var i = 0; i < menuBars.length; i++) {
          (function(i){menuBars[i].dispatchEvent(customEvent)})(i);
        };
      };
    }
  }
}());
// File#: _2_morphing-image-modal
// Usage: codyhouse.co/license
(function() {
  var MorphImgModal = function(opts) {
    this.options = Util.extend(MorphImgModal.defaults, opts);
    this.element = this.options.element;
    this.modalId = this.element.getAttribute('id');
    this.triggers = document.querySelectorAll('[aria-controls="'+this.modalId+'"]');
    this.selectedImg = false;
    // store morph elements
    this.morphBg = document.getElementsByClassName('js-morph-img-bg');
    this.morphImg = document.getElementsByClassName('js-morph-img-clone');
    // store modal content
    this.modalContent = this.element.getElementsByClassName('js-morph-img-modal__content');
    this.modalImg = this.element.getElementsByClassName('js-morph-img-modal__img');
    this.modalInfo = this.element.getElementsByClassName('js-morph-img-modal__info');
    // store close btn element
    this.modalCloseBtn = document.getElementsByClassName('js-morph-img-close-btn');
    // animation duration
    this.animationDuration = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--morph-img-modal-transition-duration'))*1000 || 300;
    // morphing animation should run
    this.animating = false;
    this.reset = false;
    initMorphModal(this);
  };

  function initMorphModal(element) {
    if(element.morphImg.length < 1) return;
    element.morphEl = element.morphImg[0].getElementsByTagName('image');
    element.morphRect  = element.morphImg[0].getElementsByTagName('rect');
    initMorphModalMarkup(element);
    initMorphModalEvents(element);
  };

  function initMorphModalMarkup(element) {
    // append the clip path + <image> elements to use to morph the image
    element.morphImg[0].innerHTML = '<svg><defs><clipPath id="'+element.modalId+'-clip"><rect/></clipPath></defs><image height="100%" width="100%" clip-path="url(#'+element.modalId+'-clip)"></image></svg>';
  };

  function initMorphModalEvents(element) {
    // morph modal was open
    element.element.addEventListener('modalIsOpen', function(event){
      var target = event.detail.closest('[aria-controls="'+element.modalId+'"]');
      setModalImg(element, target);
      setModalContent(element, target);
      toggleModalCloseBtn(element, true);
    });

    // morph modal was closed
    element.element.addEventListener('modalIsClose', function(event){
      element.reset = false;
      element.animating = true;
      Util.addClass(element.modalContent[0], 'opacity-0');
      animateImg(element, false, function() {
        if(element.reset) return; // user opened a new modal before the animation was complete - no need to reset the modal
        element.selectedImg = false;
        resetMorphModal(element, false);
        element.animating = false;
      });
      toggleModalCloseBtn(element, false);
    });

    // close modal clicking on close btn
    if(element.modalCloseBtn.length > 0) {
      element.modalCloseBtn[0].addEventListener('click', function(event) {
        element.element.click();
      });
    }
  };

  function setModalImg(element, target) {
    if(!target) return;
    element.selectedImg = (target.tagName.toLowerCase() == 'img') ? target : target.querySelector('img');
    var src = element.selectedImg.getAttribute('data-modal-src') || element.selectedImg.getAttribute('src');
    // update url modal image + morph
    if(element.modalImg.length > 0) element.modalImg[0].setAttribute('src', src);
    Util.setAttributes(element.morphEl[0], {'xlink:href': src, 'href': src});
    element.reset = false;
    element.animating = true;  
    // wait for image to be loaded, then animate
    loadImage(element, src, function() {
      animateImg(element, true, function() {
        if(element.reset) return; // user closed the modal before the animation was complete - no need to reset the modal
        resetMorphModal(element, true);
        element.animating = false;
      });
    });
  };

  function loadImage(element, src, cb) {
    var image = new Image();
    var loaded = false;
    image.onload = function () {
      if(loaded) return;
      cb();
    }
    image.src = src;
    if(image.complete) {
      loaded = true;
      cb();
    }
  };

  function setModalContent(element, target) {
    // load the modal info details - using the searchData custom function the user defines
    if(element.modalInfo.length < 1) return;
    element.options.searchData(target, function(data){
      element.modalInfo[0].innerHTML = data;
    });
  };

  function toggleModalCloseBtn(element, bool) {
    if(element.modalCloseBtn.length > 0) {
      Util.toggleClass(element.modalCloseBtn[0], 'morph-img-close-btn--is-visible', bool);
    }
  };

  function animateImg(element, isOpening, cb) {
    Util.removeClass(element.morphImg[0], 'is-hidden');

    var galleryImgRect = element.selectedImg.getBoundingClientRect(),
      modalImgRect = element.modalImg[0].getBoundingClientRect();

    runClipAnimation(element, galleryImgRect, modalImgRect, isOpening, cb);
  };

  function runClipAnimation(element, startRect, endRect, isOpening, cb) {
    // retrieve all animation params
    // main element animation (<div>)
    var elInitHeight = startRect.height,
      elIntWidth = startRect.width,
      elInitTop = startRect.top,
      elInitLeft = startRect.left;
    
    var elScale = Math.max(endRect.height/startRect.height, endRect.width/startRect.width);

    var elTranslateX = endRect.left - startRect.left + (endRect.width - startRect.width*elScale)*0.5,
      elTranslateY = endRect.top - startRect.top + (endRect.height - startRect.height*elScale)*0.5;

    // clip <rect> animation
    var rectScaleX = endRect.width/(startRect.width*elScale),
      rectScaleY = endRect.height/(startRect.height*elScale);

    element.morphImg[0].style = 'height:'+elInitHeight+'px; width:'+elIntWidth+'px; top:'+elInitTop+'px; left:'+elInitLeft+'px;';

    element.morphRect[0].setAttribute('transform', 'scale('+1+','+1+')');

    // init morph bg
    element.morphBg[0].style.height = startRect.height + 'px';
    element.morphBg[0].style.width = startRect.width + 'px';
    element.morphBg[0].style.top = startRect.top + 'px';
    element.morphBg[0].style.left = startRect.left + 'px';

    Util.removeClass(element.morphBg[0], 'is-hidden');
    
    animateRectScale(element, elInitHeight, elIntWidth, elScale, elTranslateX, elTranslateY, rectScaleX, rectScaleY, isOpening, cb);
  };

  function animateRectScale(element, height, width, elScale, elTranslateX, elTranslateY, rectScaleX, rectScaleY, isOpening, cb) {
    var isMobile = getComputedStyle(element.element, ':before').getPropertyValue('content').replace(/\'|"/g, '') == 'mobile';

    var currentTime = null,
      duration =  element.animationDuration;

    var startRect = element.selectedImg.getBoundingClientRect(),
      endRect = element.modalContent[0].getBoundingClientRect();
    
    var scaleX = endRect.width/startRect.width,
      scaleY = endRect.height/startRect.height;
  
    var translateX = endRect.left - startRect.left,
      translateY = endRect.top - startRect.top;

    var animateScale = function(timestamp){  
      if (!currentTime) currentTime = timestamp;         
      var progress = timestamp - currentTime;
      if(progress > duration) progress = duration;
      
      // main element values
      if(isOpening) {
        var elScalePr = Math.easeOutQuart(progress, 1, elScale - 1, duration),
        elTransXPr = Math.easeOutQuart(progress, 0, elTranslateX, duration),
        elTransYPr = Math.easeOutQuart(progress, 0, elTranslateY, duration);
      } else {
        var elScalePr = Math.easeOutQuart(progress, elScale, 1 - elScale, duration),
        elTransXPr = Math.easeOutQuart(progress, elTranslateX, - elTranslateX, duration),
        elTransYPr = Math.easeOutQuart(progress, elTranslateY, - elTranslateY, duration);
      }
      
      // rect values
      if(isOpening) {
        var rectScaleXPr = Math.easeOutQuart(progress, 1, rectScaleX - 1, duration),
          rectScaleYPr = Math.easeOutQuart(progress, 1, rectScaleY - 1, duration);
      } else {
        var rectScaleXPr = Math.easeOutQuart(progress, rectScaleX,  1 - rectScaleX, duration),
          rectScaleYPr = Math.easeOutQuart(progress, rectScaleY, 1 - rectScaleY, duration);
      }

      element.morphImg[0].style.transform = 'translateX('+elTransXPr+'px) translateY('+elTransYPr+'px) scale('+elScalePr+')';

      element.morphRect[0].setAttribute('transform', 'translate('+(width/2)*(1 - rectScaleXPr)+' '+(height/2)*(1 - rectScaleYPr)+') scale('+rectScaleXPr+','+rectScaleYPr+')');

      if(isOpening) {
        var valScaleX = Math.easeOutQuart(progress, 1, (scaleX - 1), duration),
          valScaleY = isMobile ? Math.easeOutQuart(progress, 1, (scaleY - 1), duration): rectScaleYPr*elScalePr,
          valTransX = Math.easeOutQuart(progress, 0, translateX, duration),
          valTransY = isMobile ? Math.easeOutQuart(progress, 0, translateY, duration) : elTransYPr + (elScalePr*height - rectScaleYPr*elScalePr*height)/2;
      } else {
        var valScaleX = Math.easeOutQuart(progress, scaleX, 1 - scaleX, duration),
          valScaleY = isMobile ? Math.easeOutQuart(progress, scaleY, 1 - scaleY, duration) : rectScaleYPr*elScalePr,
          valTransX = Math.easeOutQuart(progress, translateX, - translateX, duration),
          valTransY = isMobile ? Math.easeOutQuart(progress, translateY, - translateY, duration) : elTransYPr + (elScalePr*height - rectScaleYPr*elScalePr*height)/2;
      }

      // morph bg
      element.morphBg[0].style.transform = 'translateX('+valTransX+'px) translateY('+valTransY+'px) scale('+valScaleX+','+valScaleY+')';

      if(progress < duration) {
        window.requestAnimationFrame(animateScale);
      } else if(cb) {
        cb();
      }
    };
    
    window.requestAnimationFrame(animateScale);
  };
  
  function resetMorphModal(element, isOpening) {
    // reset modal at the end of an opening/closing animation
    Util.toggleClass(element.modalContent[0], 'opacity-0', !isOpening);
    Util.toggleClass(element.modalInfo[0], 'opacity-0', !isOpening);
    Util.addClass(element.morphBg[0], 'is-hidden');
    Util.addClass(element.morphImg[0], 'is-hidden');
    if(!isOpening) {
      element.modalImg[0].removeAttribute('src');
      element.modalInfo[0].innerHTML = '';
      element.morphEl[0].removeAttribute('xlink:href');
      element.morphEl[0].removeAttribute('href');
      element.morphBg[0].removeAttribute('style');
      element.morphImg[0].removeAttribute('style');
    }
  };

  window.MorphImgModal = MorphImgModal;

  MorphImgModal.defaults = {
    element : '',
    searchData: false, // function used to return results
  };
}());
// File#: _2_slideshow
// Usage: codyhouse.co/license
(function() {
	var Slideshow = function(opts) {
		this.options = Util.extend(Slideshow.defaults , opts);
		this.element = this.options.element;
		this.items = this.element.getElementsByClassName('js-slideshow__item');
		this.controls = this.element.getElementsByClassName('js-slideshow__control'); 
		this.selectedSlide = 0;
		this.autoplayId = false;
		this.autoplayPaused = false;
		this.navigation = false;
		this.navCurrentLabel = false;
		this.ariaLive = false;
		this.moveFocus = false;
		this.animating = false;
		this.supportAnimation = Util.cssSupports('transition');
		this.animationOff = (!Util.hasClass(this.element, 'slideshow--transition-fade') && !Util.hasClass(this.element, 'slideshow--transition-slide') && !Util.hasClass(this.element, 'slideshow--transition-prx'));
		this.animationType = Util.hasClass(this.element, 'slideshow--transition-prx') ? 'prx' : 'slide';
		this.animatingClass = 'slideshow--is-animating';
		initSlideshow(this);
		initSlideshowEvents(this);
		initAnimationEndEvents(this);
	};

	Slideshow.prototype.showNext = function() {
		showNewItem(this, this.selectedSlide + 1, 'next');
	};

	Slideshow.prototype.showPrev = function() {
		showNewItem(this, this.selectedSlide - 1, 'prev');
	};

	Slideshow.prototype.showItem = function(index) {
		showNewItem(this, index, false);
	};

	Slideshow.prototype.startAutoplay = function() {
		var self = this;
		if(this.options.autoplay && !this.autoplayId && !this.autoplayPaused) {
			self.autoplayId = setInterval(function(){
				self.showNext();
			}, self.options.autoplayInterval);
		}
	};

	Slideshow.prototype.pauseAutoplay = function() {
		var self = this;
		if(this.options.autoplay) {
			clearInterval(self.autoplayId);
			self.autoplayId = false;
		}
	};

	function initSlideshow(slideshow) { // basic slideshow settings
		// if no slide has been selected -> select the first one
		if(slideshow.element.getElementsByClassName('slideshow__item--selected').length < 1) Util.addClass(slideshow.items[0], 'slideshow__item--selected');
		slideshow.selectedSlide = Util.getIndexInArray(slideshow.items, slideshow.element.getElementsByClassName('slideshow__item--selected')[0]);
		// create an element that will be used to announce the new visible slide to SR
		var srLiveArea = document.createElement('div');
		Util.setAttributes(srLiveArea, {'class': 'sr-only js-slideshow__aria-live', 'aria-live': 'polite', 'aria-atomic': 'true'});
		slideshow.element.appendChild(srLiveArea);
		slideshow.ariaLive = srLiveArea;
	};

	function initSlideshowEvents(slideshow) {
		// if slideshow navigation is on -> create navigation HTML and add event listeners
		if(slideshow.options.navigation) {
			// check if navigation has already been included
			if(slideshow.element.getElementsByClassName('js-slideshow__navigation').length == 0) {
				var navigation = document.createElement('ol'),
					navChildren = '';

				var navClasses = 'slideshow__navigation js-slideshow__navigation';
				if(slideshow.items.length <= 1) {
					navClasses = navClasses + ' is-hidden';
				} 
				
				navigation.setAttribute('class', navClasses);
				for(var i = 0; i < slideshow.items.length; i++) {
					var className = (i == slideshow.selectedSlide) ? 'class="slideshow__nav-item slideshow__nav-item--selected js-slideshow__nav-item"' :  'class="slideshow__nav-item js-slideshow__nav-item"',
						navCurrentLabel = (i == slideshow.selectedSlide) ? '<span class="sr-only js-slideshow__nav-current-label">Current Item</span>' : '';
					navChildren = navChildren + '<li '+className+'><button class="reset"><span class="sr-only">'+ (i+1) + '</span>'+navCurrentLabel+'</button></li>';
				}
				navigation.innerHTML = navChildren;
				slideshow.element.appendChild(navigation);
			}
			
			slideshow.navCurrentLabel = slideshow.element.getElementsByClassName('js-slideshow__nav-current-label')[0]; 
			slideshow.navigation = slideshow.element.getElementsByClassName('js-slideshow__nav-item');

			var dotsNavigation = slideshow.element.getElementsByClassName('js-slideshow__navigation')[0];

			dotsNavigation.addEventListener('click', function(event){
				navigateSlide(slideshow, event, true);
			});
			dotsNavigation.addEventListener('keyup', function(event){
				navigateSlide(slideshow, event, (event.key.toLowerCase() == 'enter'));
			});
		}
		// slideshow arrow controls
		if(slideshow.controls.length > 0) {
			// hide controls if one item available
			if(slideshow.items.length <= 1) {
				Util.addClass(slideshow.controls[0], 'is-hidden');
				Util.addClass(slideshow.controls[1], 'is-hidden');
			}
			slideshow.controls[0].addEventListener('click', function(event){
				event.preventDefault();
				slideshow.showPrev();
				updateAriaLive(slideshow);
			});
			slideshow.controls[1].addEventListener('click', function(event){
				event.preventDefault();
				slideshow.showNext();
				updateAriaLive(slideshow);
			});
		}
		// swipe events
		if(slideshow.options.swipe) {
			//init swipe
			new SwipeContent(slideshow.element);
			slideshow.element.addEventListener('swipeLeft', function(event){
				slideshow.showNext();
			});
			slideshow.element.addEventListener('swipeRight', function(event){
				slideshow.showPrev();
			});
		}
		// autoplay
		if(slideshow.options.autoplay) {
			slideshow.startAutoplay();
			// pause autoplay if user is interacting with the slideshow
			if(!slideshow.options.autoplayOnHover) {
				slideshow.element.addEventListener('mouseenter', function(event){
					slideshow.pauseAutoplay();
					slideshow.autoplayPaused = true;
				});
				slideshow.element.addEventListener('mouseleave', function(event){
					slideshow.autoplayPaused = false;
					slideshow.startAutoplay();
				});
			}
			
			slideshow.element.addEventListener('focusin', function(event){
				slideshow.pauseAutoplay();
				slideshow.autoplayPaused = true;
			});
			slideshow.element.addEventListener('focusout', function(event){
				slideshow.autoplayPaused = false;
				slideshow.startAutoplay();
			});
		}
		// detect if external buttons control the slideshow
		var slideshowId = slideshow.element.getAttribute('id');
		if(slideshowId) {
			var externalControls = document.querySelectorAll('[data-controls="'+slideshowId+'"]');
			for(var i = 0; i < externalControls.length; i++) {
				(function(i){externalControlSlide(slideshow, externalControls[i]);})(i);
			}
		}
		// custom event to trigger selection of a new slide element
		slideshow.element.addEventListener('selectNewItem', function(event){
			// check if slide is already selected
			if(event.detail) {
				if(event.detail - 1 == slideshow.selectedSlide) return;
				showNewItem(slideshow, event.detail - 1, false);
			}
		});

		// keyboard navigation
		slideshow.element.addEventListener('keydown', function(event){
			if(event.keyCode && event.keyCode == 39 || event.key && event.key.toLowerCase() == 'arrowright') {
				slideshow.showNext();
			} else if(event.keyCode && event.keyCode == 37 || event.key && event.key.toLowerCase() == 'arrowleft') {
				slideshow.showPrev();
			}
		});
	};

	function navigateSlide(slideshow, event, keyNav) { 
		// user has interacted with the slideshow navigation -> update visible slide
		var target = ( Util.hasClass(event.target, 'js-slideshow__nav-item') ) ? event.target : event.target.closest('.js-slideshow__nav-item');
		if(keyNav && target && !Util.hasClass(target, 'slideshow__nav-item--selected')) {
			slideshow.showItem(Util.getIndexInArray(slideshow.navigation, target));
			slideshow.moveFocus = true;
			updateAriaLive(slideshow);
		}
	};

	function initAnimationEndEvents(slideshow) {
		// remove animation classes at the end of a slide transition
		for( var i = 0; i < slideshow.items.length; i++) {
			(function(i){
				slideshow.items[i].addEventListener('animationend', function(){resetAnimationEnd(slideshow, slideshow.items[i]);});
				slideshow.items[i].addEventListener('transitionend', function(){resetAnimationEnd(slideshow, slideshow.items[i]);});
			})(i);
		}
	};

	function resetAnimationEnd(slideshow, item) {
		setTimeout(function(){ // add a delay between the end of animation and slideshow reset - improve animation performance
			if(Util.hasClass(item,'slideshow__item--selected')) {
				if(slideshow.moveFocus) Util.moveFocus(item);
				emitSlideshowEvent(slideshow, 'newItemVisible', slideshow.selectedSlide);
				slideshow.moveFocus = false;
			}
			Util.removeClass(item, 'slideshow__item--'+slideshow.animationType+'-out-left slideshow__item--'+slideshow.animationType+'-out-right slideshow__item--'+slideshow.animationType+'-in-left slideshow__item--'+slideshow.animationType+'-in-right');
			item.removeAttribute('aria-hidden');
			slideshow.animating = false;
			Util.removeClass(slideshow.element, slideshow.animatingClass); 
		}, 100);
	};

	function showNewItem(slideshow, index, bool) {
		if(slideshow.items.length <= 1) return;
		if(slideshow.animating && slideshow.supportAnimation) return;
		slideshow.animating = true;
		Util.addClass(slideshow.element, slideshow.animatingClass); 
		if(index < 0) index = slideshow.items.length - 1;
		else if(index >= slideshow.items.length) index = 0;
		// skip slideshow item if it is hidden
		if(bool && Util.hasClass(slideshow.items[index], 'is-hidden')) {
			slideshow.animating = false;
			index = bool == 'next' ? index + 1 : index - 1;
			showNewItem(slideshow, index, bool);
			return;
		}
		// index of new slide is equal to index of slide selected item
		if(index == slideshow.selectedSlide) {
			slideshow.animating = false;
			return;
		}
		var exitItemClass = getExitItemClass(slideshow, bool, slideshow.selectedSlide, index);
		var enterItemClass = getEnterItemClass(slideshow, bool, slideshow.selectedSlide, index);
		// transition between slides
		if(!slideshow.animationOff) Util.addClass(slideshow.items[slideshow.selectedSlide], exitItemClass);
		Util.removeClass(slideshow.items[slideshow.selectedSlide], 'slideshow__item--selected');
		slideshow.items[slideshow.selectedSlide].setAttribute('aria-hidden', 'true'); //hide to sr element that is exiting the viewport
		if(slideshow.animationOff) {
			Util.addClass(slideshow.items[index], 'slideshow__item--selected');
		} else {
			Util.addClass(slideshow.items[index], enterItemClass+' slideshow__item--selected');
		}
		// reset slider navigation appearance
		resetSlideshowNav(slideshow, index, slideshow.selectedSlide);
		slideshow.selectedSlide = index;
		// reset autoplay
		slideshow.pauseAutoplay();
		slideshow.startAutoplay();
		// reset controls/navigation color themes
		resetSlideshowTheme(slideshow, index);
		// emit event
		emitSlideshowEvent(slideshow, 'newItemSelected', slideshow.selectedSlide);
		if(slideshow.animationOff) {
			slideshow.animating = false;
			Util.removeClass(slideshow.element, slideshow.animatingClass);
		}
	};

	function getExitItemClass(slideshow, bool, oldIndex, newIndex) {
		var className = '';
		if(bool) {
			className = (bool == 'next') ? 'slideshow__item--'+slideshow.animationType+'-out-right' : 'slideshow__item--'+slideshow.animationType+'-out-left'; 
		} else {
			className = (newIndex < oldIndex) ? 'slideshow__item--'+slideshow.animationType+'-out-left' : 'slideshow__item--'+slideshow.animationType+'-out-right';
		}
		return className;
	};

	function getEnterItemClass(slideshow, bool, oldIndex, newIndex) {
		var className = '';
		if(bool) {
			className = (bool == 'next') ? 'slideshow__item--'+slideshow.animationType+'-in-right' : 'slideshow__item--'+slideshow.animationType+'-in-left'; 
		} else {
			className = (newIndex < oldIndex) ? 'slideshow__item--'+slideshow.animationType+'-in-left' : 'slideshow__item--'+slideshow.animationType+'-in-right';
		}
		return className;
	};

	function resetSlideshowNav(slideshow, newIndex, oldIndex) {
		if(slideshow.navigation) {
			Util.removeClass(slideshow.navigation[oldIndex], 'slideshow__nav-item--selected');
			Util.addClass(slideshow.navigation[newIndex], 'slideshow__nav-item--selected');
			slideshow.navCurrentLabel.parentElement.removeChild(slideshow.navCurrentLabel);
			slideshow.navigation[newIndex].getElementsByTagName('button')[0].appendChild(slideshow.navCurrentLabel);
		}
	};

	function resetSlideshowTheme(slideshow, newIndex) {
		var dataTheme = slideshow.items[newIndex].getAttribute('data-theme');
		if(dataTheme) {
			if(slideshow.navigation) slideshow.navigation[0].parentElement.setAttribute('data-theme', dataTheme);
			if(slideshow.controls[0]) slideshow.controls[0].parentElement.setAttribute('data-theme', dataTheme);
		} else {
			if(slideshow.navigation) slideshow.navigation[0].parentElement.removeAttribute('data-theme');
			if(slideshow.controls[0]) slideshow.controls[0].parentElement.removeAttribute('data-theme');
		}
	};

	function emitSlideshowEvent(slideshow, eventName, detail) {
		var event = new CustomEvent(eventName, {detail: detail});
		slideshow.element.dispatchEvent(event);
	};

	function updateAriaLive(slideshow) {
		slideshow.ariaLive.innerHTML = 'Item '+(slideshow.selectedSlide + 1)+' of '+slideshow.items.length;
	};

	function externalControlSlide(slideshow, button) { // control slideshow using external element
		button.addEventListener('click', function(event){
			var index = button.getAttribute('data-index');
			if(!index || index == slideshow.selectedSlide + 1) return;
			event.preventDefault();
			showNewItem(slideshow, index - 1, false);
		});
	};

	Slideshow.defaults = {
    element : '',
    navigation : true,
    autoplay : false,
		autoplayOnHover: false,
    autoplayInterval: 5000,
    swipe: false
  };

	window.Slideshow = Slideshow;
	
	//initialize the Slideshow objects
	var slideshows = document.getElementsByClassName('js-slideshow');
	if( slideshows.length > 0 ) {
		for( var i = 0; i < slideshows.length; i++) {
			(function(i){
				var navigation = (slideshows[i].getAttribute('data-navigation') && slideshows[i].getAttribute('data-navigation') == 'off') ? false : true,
					autoplay = (slideshows[i].getAttribute('data-autoplay') && slideshows[i].getAttribute('data-autoplay') == 'on') ? true : false,
					autoplayOnHover = (slideshows[i].getAttribute('data-autoplay-hover') && slideshows[i].getAttribute('data-autoplay-hover') == 'on') ? true : false,
					autoplayInterval = (slideshows[i].getAttribute('data-autoplay-interval')) ? slideshows[i].getAttribute('data-autoplay-interval') : 5000,
					swipe = (slideshows[i].getAttribute('data-swipe') && slideshows[i].getAttribute('data-swipe') == 'on') ? true : false;
				new Slideshow({element: slideshows[i], navigation: navigation, autoplay : autoplay, autoplayOnHover: autoplayOnHover, autoplayInterval : autoplayInterval, swipe : swipe});
			})(i);
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
    this.clickScrolling = false;
    this.intervalID = false;
    this.staticLayoutClass = 'toc--static';
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
// File#: _3_expandable-img-gallery
// Usage: codyhouse.co/license

(function() {
  var ExpGallery = function(element) {
    this.element = element;
    this.slideshow = this.element.getElementsByClassName('js-exp-lightbox__body')[0];
    this.slideshowList = this.element.getElementsByClassName('js-exp-lightbox__slideshow')[0];
    this.slideshowId = this.element.getAttribute('id')
    this.gallery = document.querySelector('[data-controls="'+this.slideshowId+'"]');
    this.galleryItems = this.gallery.getElementsByClassName('js-exp-gallery__item');
    this.lazyload = this.gallery.getAttribute('data-placeholder');
    this.animationRunning = false;
    // menu bar
    this.menuBar = this.element.getElementsByClassName('js-menu-bar');
    initNewContent(this);
    initLightboxMarkup(this);
    lazyLoadLightbox(this);
    initSlideshow(this);
    initModal(this);
    initModalEvents(this);
  };

  function initNewContent(gallery) {
    // if the gallery uses the infinite load - make sure to update the modal gallery when new content is loaded
    gallery.infiniteScrollParent = gallery.gallery.closest('[data-container]');
    
    if(!gallery.infiniteScrollParent && Util.hasClass(gallery.gallery, 'js-infinite-scroll')) {
      gallery.infiniteScrollParent = gallery.gallery;
    }
    
    if(gallery.infiniteScrollParent) {
      gallery.infiniteScrollParent.addEventListener('content-loaded', function(event){
        initLightboxMarkup(gallery);
        initSlideshow(gallery);
      });
    }
  };

  function initLightboxMarkup(gallery) {
    // create items inside lightbox - modal slideshow
    var slideshowContent = '';
    for(var i = 0; i < gallery.galleryItems.length; i++) {
      var caption = gallery.galleryItems[i].getElementsByClassName('js-exp-gallery__caption'),
        image = gallery.galleryItems[i].getElementsByTagName('img')[0],
        caption = gallery.galleryItems[i].getElementsByClassName('js-exp-gallery__caption');
      // details
      var src = image.getAttribute('data-modal-src');
      if(!src) src = image.getAttribute('data-src');
      if(!src) src = image.getAttribute('src');
      var altAttr = image.getAttribute('alt')
      altAttr = altAttr ? 'alt="'+altAttr+'"' : '';
      var draggable = gallery.slideshow.getAttribute('data-swipe') == 'on' ? 'draggable="false" ondragstart="return false;"' : '';
      var imgBlock = gallery.lazyload 
        ? '<img data-src="'+src+'" data-loading="lazy" src="'+gallery.lazyload+'" '+altAttr+' '+draggable+' class=" pointer-events-auto">'
        : '<img src="'+src+'" data-loading="lazy" '+draggable+' class=" pointer-events-auto">';

      var captionBlock = caption.length > 0
        ? '<figcaption class="exp-lightbox__caption pointer-events-auto">'+caption[0].textContent+'</figcaption>'
        : '';

      slideshowContent = slideshowContent + '<li class="slideshow__item js-slideshow__item"><figure class="exp-lightbox__media"><div class="exp-lightbox__media-outer"><div class="exp-lightbox__media-inner">'+imgBlock+'</div></div>'+captionBlock+'</li>';
    }
    gallery.slideshowList.innerHTML = slideshowContent;
    gallery.slides = gallery.slideshowList.getElementsByClassName('js-slideshow__item');

    // append the morphing image - we will animate it from the selected slide to the final position (and viceversa)
    var imgMorph = document.createElement("div");
    Util.setAttributes(imgMorph, {'aria-hidden': 'true', 'class': 'exp-lightbox__clone-img-wrapper js-exp-lightbox__clone-img-wrapper', 'data-exp-morph': gallery.slideshowId});
    imgMorph.innerHTML = '<svg><defs><clipPath id="'+gallery.slideshowId+'-clip"><rect/></clipPath></defs><image height="100%" width="100%" clip-path="url(#'+gallery.slideshowId+'-clip)"></image></svg>';
    document.body.appendChild(imgMorph);
    gallery.imgMorph = document.querySelector('.js-exp-lightbox__clone-img-wrapper[data-exp-morph="'+gallery.slideshowId+'"]');
    gallery.imgMorphSVG = gallery.imgMorph.getElementsByTagName('svg')[0];
    gallery.imgMorphRect = gallery.imgMorph.getElementsByTagName('rect')[0];
    gallery.imgMorphImg = gallery.imgMorph.getElementsByTagName('image')[0];
    
    // append image for zoom in effect
    if(gallery.slideshow.getAttribute('data-zoom') == 'on') {
      var zoomImg = document.createElement("div");
      Util.setAttributes(zoomImg, {'aria-hidden': 'true', 'class': 'exp-lightbox__zoom exp-lightbox__zoom--no-transition js-exp-lightbox__zoom'});
      zoomImg.innerHTML = '<img>';
      gallery.element.appendChild(zoomImg);
      gallery.zoomImg = gallery.element.getElementsByClassName('js-exp-lightbox__zoom')[0];
    }
  };

  function lazyLoadLightbox(gallery) {
    // lazyload media of selected slide/prev slide/next slide
    gallery.slideshow.addEventListener('newItemSelected', function(event){
      // 'newItemSelected' is emitted by the Slideshow object when a new slide is selected
      gallery.selectedSlide = event.detail;
      lazyLoadSlide(gallery);
      // menu element - trigger new slide event
      triggerMenuEvent(gallery);
    });
  };

  function lazyLoadSlide(gallery) {
    setSlideMedia(gallery, gallery.selectedSlide);
    setSlideMedia(gallery, gallery.selectedSlide + 1);
    setSlideMedia(gallery, gallery.selectedSlide - 1);
  };

  function setSlideMedia(gallery, index) {
    if(index < 0) index = gallery.slides.length - 1;
    if(index > gallery.slides.length - 1) index = 0;
    var imgs = gallery.slides[index].querySelectorAll('img[data-src]');
    for(var i = 0; i < imgs.length; i++) {
      imgs[i].src = imgs[i].getAttribute('data-src');
    }
  };

  function initSlideshow(gallery) { 
    // reset slideshow navigation
    resetSlideshowControls(gallery);
    gallery.slideshowNav = gallery.element.getElementsByClassName('js-slideshow__control');

    if(gallery.slides.length <= 1) {
      toggleSlideshowElements(gallery, true);
      return;
    } 
    var swipe = (gallery.slideshow.getAttribute('data-swipe') && gallery.slideshow.getAttribute('data-swipe') == 'on') ? true : false;
    gallery.slideshowObj = new Slideshow({element: gallery.slideshow, navigation: false, autoplay : false, swipe : swipe});
  };

  function resetSlideshowControls(gallery) {
    var arrowControl = gallery.element.getElementsByClassName('js-slideshow__control');
    if(arrowControl.length == 0) return;
    var controlsWrapper = arrowControl[0].parentElement;
    if(!controlsWrapper) return;
    controlsWrapper.innerHTML = controlsWrapper.innerHTML;
  };

  function toggleSlideshowElements(gallery, bool) { // hide slideshow controls if gallery is composed by one item only
    if(gallery.slideshowNav.length > 0) {
      for(var i = 0; i < gallery.slideshowNav.length; i++) {
        bool ? Util.addClass(gallery.slideshowNav[i], 'is-hidden') : Util.removeClass(gallery.slideshowNav[i], 'is-hidden');
      }
    }
  };

  function initModal(gallery) {
    Util.addClass(gallery.element, 'exp-lightbox--no-transition'); // add no-transition class to lightbox - used to select the first visible slide
    gallery.element.addEventListener('modalIsClose', function(event){ // add no-transition class
      Util.addClass(gallery.element, 'exp-lightbox--no-transition');
      gallery.imgMorph.style = '';
    });
    // trigger modal lightbox
    gallery.gallery.addEventListener('click', function(event){
      openModalLightbox(gallery, event);
    });
  };

  function initModalEvents(gallery) {
   if(gallery.zoomImg) { // image zoom
      gallery.slideshow.addEventListener('click', function(event){
        if(event.target.tagName.toLowerCase() == 'img' && event.target.closest('.js-slideshow__item') && !gallery.modalSwiping) modalZoomImg(gallery, event.target);
      });

      gallery.zoomImg.addEventListener('click', function(event){
        modalZoomImg(gallery, false);
      });

      gallery.element.addEventListener('modalIsClose', function(event){
        modalZoomImg(gallery, false); // close zoom-in image if open
        closeModalAnimation(gallery);
      });
    }

    if(!gallery.slideshowObj) return;

    if(gallery.slideshowObj.options.swipe) { // close gallery when you swipeUp/SwipeDown
      gallery.slideshowObj.element.addEventListener('swipeUp', function(event){
        closeModal(gallery);
      });
      gallery.slideshowObj.element.addEventListener('swipeDown', function(event){
        closeModal(gallery);
      });
    }
    
    if(gallery.zoomImg && gallery.slideshowObj.options.swipe) {
      gallery.slideshowObj.element.addEventListener('swipeLeft', function(event){
        gallery.modalSwiping = true;
      });
      gallery.slideshowObj.element.addEventListener('swipeRight', function(event){
        gallery.modalSwiping = true;
      });
      gallery.slideshowObj.element.addEventListener('newItemVisible', function(event){
        gallery.modalSwiping = false;
      });
    }
  };

  function openModalLightbox(gallery, event) {
    var item = event.target.closest('.js-exp-gallery__item');
    if(!item) return;
    // reset slideshow items visibility
    resetSlideshowItemsVisibility(gallery);
    gallery.selectedSlide = Util.getIndexInArray(gallery.galleryItems, item);
    setSelectedItem(gallery);
    lazyLoadSlide(gallery);
    if(animationSupported) { // start expanding animation
      window.requestAnimationFrame(function(){
        animateSelectedImage(gallery);
        openModal(gallery, item);
      });
    } else { // no expanding animation -> show modal
      openModal(gallery, item);
      Util.removeClass(gallery.element, 'exp-lightbox--no-transition');
    }
    // menu element - trigger new slide event
    triggerMenuEvent(gallery);
  };

  function resetSlideshowItemsVisibility(gallery) {
    var index = 0;
    for(var i = 0; i < gallery.galleryItems.length; i++) {
      var itemVisible = isVisible(gallery.galleryItems[i]);
      if(itemVisible) {
        index = index + 1;
        Util.removeClass(gallery.slides[i], 'is-hidden');
      } else {
        Util.addClass(gallery.slides[i], 'is-hidden');
      }
    }
    toggleSlideshowElements(gallery, index < 2);
  };

  function setSelectedItem(gallery) {
    // if a specific slide was selected -> make sure to show that item first
    var lastSelected = gallery.slideshow.getElementsByClassName('slideshow__item--selected');
    if(lastSelected.length > 0 ) Util.removeClass(lastSelected[0], 'slideshow__item--selected');
    Util.addClass(gallery.slides[gallery.selectedSlide], 'slideshow__item--selected');
    if(gallery.slideshowObj) gallery.slideshowObj.selectedSlide = gallery.selectedSlide;
  };

  function openModal(gallery, item) {
    gallery.element.dispatchEvent(new CustomEvent('openModal', {detail: item}));
    gallery.modalSwiping = false;
  };

  function closeModal(gallery) {
    gallery.modalSwiping = true;
    modalZoomImg(gallery, false);
    gallery.element.dispatchEvent(new CustomEvent('closeModal'));
  };

  function closeModalAnimation(gallery) { // modal is already closing -> start image closing animation
    gallery.selectedSlide = gallery.slideshowObj ? gallery.slideshowObj.selectedSlide : 0;
    // on close - make sure last selected image (of the gallery) is in the viewport
    var boundingRect = gallery.galleryItems[gallery.selectedSlide].getBoundingClientRect();
		if(boundingRect.top < 0 || boundingRect.top > window.innerHeight) {
			var windowScrollTop = window.scrollY || document.documentElement.scrollTop;
			window.scrollTo(0, boundingRect.top + windowScrollTop);
		}
    // animate on close
    animateSelectedImage(gallery, true);
  };

  function modalZoomImg(gallery, img) { // toggle zoom-in image
    if(!gallery.zoomImg) return;
    var bool = false;
    if(img) { // open zoom-in image
      gallery.originImg = img;
      gallery.zoomImg.children[0].setAttribute('src', img.getAttribute('src'));
      bool = true;
    }
    (animationSupported) 
      ? requestAnimationFrame(function(){animateZoomImg(gallery, bool)})
      : Util.toggleClass(gallery.zoomImg, 'exp-lightbox__zoom--is-visible', bool);
  };

  function animateZoomImg(gallery, bool) {
    if(!gallery.originImg) return;
    
    var originImgPosition = gallery.originImg.getBoundingClientRect(),
      originStyle = 'translateX('+originImgPosition.left+'px) translateY('+(originImgPosition.top + gallery.zoomImg.scrollTop)+'px) scale('+ originImgPosition.width/gallery.zoomImg.scrollWidth+')',
      finalStyle = 'scale(1)';

    if(bool) {
      gallery.zoomImg.children[0].style.transform = originStyle;
    } else {
      gallery.zoomImg.addEventListener('transitionend', function cb(){
        Util.addClass(gallery.zoomImg, 'exp-lightbox__zoom--no-transition');
        gallery.zoomImg.scrollTop = 0;
        gallery.zoomImg.removeEventListener('transitionend', cb);
      });
    }
    setTimeout(function(){
      Util.removeClass(gallery.zoomImg, 'exp-lightbox__zoom--no-transition');
      Util.toggleClass(gallery.zoomImg, 'exp-lightbox__zoom--is-visible', bool);
      gallery.zoomImg.children[0].style.transform = (bool) ? finalStyle : originStyle;
    }, 50);
  };

  function animateSelectedImage(gallery, bool) { // create morphing image effect
    var imgInit = gallery.galleryItems[gallery.selectedSlide].getElementsByTagName('img')[0],
      imgInitPosition = imgInit.getBoundingClientRect(),
      imgFinal = gallery.slides[gallery.selectedSlide].getElementsByTagName('img')[0],
      imgFinalPosition = imgFinal.getBoundingClientRect();

    if(bool) {
      runAnimation(gallery, imgInit, imgInitPosition, imgFinal, imgFinalPosition, bool);
    } else {
      imgFinal.style.visibility = 'hidden';
      gallery.animationRunning = false;
      var image = new Image();
      image.onload = function () {
        if(gallery.animationRunning) return;
        imgFinalPosition = imgFinal.getBoundingClientRect();
        runAnimation(gallery, imgInit, imgInitPosition, imgFinal, imgFinalPosition, bool);
      }
      image.src = imgFinal.getAttribute('data-src') ? imgFinal.getAttribute('data-src') : imgFinal.getAttribute('src');
      if(image.complete) {
        gallery.animationRunning = true;
        imgFinalPosition = imgFinal.getBoundingClientRect();
        runAnimation(gallery, imgInit, imgInitPosition, imgFinal, imgFinalPosition, bool);
      }
    }
  };

  function runAnimation(gallery, imgInit, imgInitPosition, imgFinal, imgFinalPosition, bool) {
    // retrieve all animation params
    var scale = imgFinalPosition.width > imgFinalPosition.height ? imgFinalPosition.height/imgInitPosition.height : imgFinalPosition.width/imgInitPosition.width;
    var initHeight = imgFinalPosition.width > imgFinalPosition.height ? imgInitPosition.height : imgFinalPosition.height/scale,
      initWidth = imgFinalPosition.width > imgFinalPosition.height ? imgFinalPosition.width/scale : imgInitPosition.width;

    var initTranslateY = (imgInitPosition.height - initHeight)/2,
      initTranslateX = (imgInitPosition.width - initWidth)/2,
      initTop = imgInitPosition.top + initTranslateY,
      initLeft = imgInitPosition.left + initTranslateX;

    // get final states
    var translateX = imgFinalPosition.left - imgInitPosition.left,
      translateY = imgFinalPosition.top - imgInitPosition.top;

    var finTranslateX = translateX - initTranslateX,
    finTranslateY = translateY - initTranslateY;

    var initScaleX = imgInitPosition.width/initWidth,
      initScaleY = imgInitPosition.height/initHeight,
      finScaleX = 1,
      finScaleY = 1;

    if(bool) { // update params if this is a closing animation
      scale = 1/scale;
      finScaleX = initScaleX;
      finScaleY = initScaleY;
      initScaleX = 1;
      initScaleY = 1;
      finTranslateX = -1*finTranslateX;
      finTranslateY = -1*finTranslateY;
      initTop = imgFinalPosition.top;
      initLeft = imgFinalPosition.left;
      initHeight = imgFinalPosition.height;
      initWidth = imgFinalPosition.width;
    }
    
    if(!bool) {
      imgFinal.style.visibility = ''; // reset visibility
    }

    // set initial status
    gallery.imgMorph.setAttribute('style', 'height: '+initHeight+'px; width: '+initWidth+'px; top: '+initTop+'px; left: '+initLeft+'px;');
    gallery.imgMorphSVG.setAttribute('viewbox', '0 0 '+initWidth+' '+initHeight);
    Util.setAttributes(gallery.imgMorphImg, {'xlink:href': imgInit.getAttribute('src'), 'href': imgInit.getAttribute('src')});
    Util.setAttributes(gallery.imgMorphRect, {'style': 'height: '+initHeight+'px; width: '+initWidth+'px;', 'transform': 'translate('+(initWidth/2)*(1 - initScaleX)+' '+(initHeight/2)*(1 - initScaleY)+') scale('+initScaleX+','+initScaleY+')'});

    // reveal image and start animation
    Util.addClass(gallery.imgMorph, 'exp-lightbox__clone-img-wrapper--is-visible');
    Util.addClass(gallery.slideshowList, 'slideshow__content--is-hidden');
    Util.addClass(gallery.galleryItems[gallery.selectedSlide], 'exp-gallery-item-hidden');

    gallery.imgMorph.addEventListener('transitionend', function cb(event){ // reset elements once animation is over
      if(event.propertyName.indexOf('transform') < 0) return;
			Util.removeClass(gallery.element, 'exp-lightbox--no-transition');
      Util.removeClass(gallery.imgMorph, 'exp-lightbox__clone-img-wrapper--is-visible');
      Util.removeClass(gallery.slideshowList, 'slideshow__content--is-hidden');
      gallery.imgMorph.removeAttribute('style');
      gallery.imgMorphRect.removeAttribute('style');
      gallery.imgMorphRect.removeAttribute('transform');
      gallery.imgMorphImg.removeAttribute('href');
      gallery.imgMorphImg.removeAttribute('xlink:href');
      Util.removeClass(gallery.galleryItems[gallery.selectedSlide], 'exp-gallery-item-hidden');
			gallery.imgMorph.removeEventListener('transitionend', cb);
    });

    // trigger expanding/closing animation
    gallery.imgMorph.style.transform = 'translateX('+finTranslateX+'px) translateY('+finTranslateY+'px) scale('+scale+')';
    animateRectScale(gallery.imgMorphRect, initScaleX, initScaleY, finScaleX, finScaleY, initWidth, initHeight);
  };

  function animateRectScale(rect, scaleX, scaleY, finScaleX, finScaleY, width, height) {
    var currentTime = null,
      duration =  parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--exp-gallery-animation-duration'))*1000 || 300;

    var animateScale = function(timestamp){  
      if (!currentTime) currentTime = timestamp;         
      var progress = timestamp - currentTime;
      if(progress > duration) progress = duration;

      var valX = easeOutQuad(progress, scaleX, finScaleX-scaleX, duration),
        valY = easeOutQuad(progress, scaleY, finScaleY-scaleY, duration);

      rect.setAttribute('transform', 'translate('+(width/2)*(1 - valX)+' '+(height/2)*(1 - valY)+') scale('+valX+','+valY+')');
      if(progress < duration) {
        window.requestAnimationFrame(animateScale);
      }
    };

    function easeOutQuad(t, b, c, d) {
      t /= d;
      return -c * t*(t-2) + b;
    };
    
    window.requestAnimationFrame(animateScale);
  };

  function keyboardNavigateLightbox(gallery, direction) {
    if(!Util.hasClass(gallery.element, 'modal--is-visible')) return;
    if(!document.activeElement.closest('.js-exp-lightbox__body') && document.activeElement.closest('.js-modal')) return;
    if(!gallery.slideshowObj) return;
    (direction == 'next') ? gallery.slideshowObj.showNext() : gallery.slideshowObj.showPrev();
  };

  function triggerMenuEvent(gallery) {
    if(gallery.menuBar.length < 1) return;
    var event = new CustomEvent('update-menu', 
      {detail: {
        index: gallery.selectedSlide,
        item: gallery.slides[gallery.selectedSlide]
      }});
    gallery.menuBar[0].dispatchEvent(event);
  };

  function isVisible(element) {
    return (element.offsetWidth || element.offsetHeight || element.getClientRects().length);
  };

  window.ExpGallery = ExpGallery;

  // init ExpGallery objects
  var expGalleries = document.getElementsByClassName('js-exp-lightbox'),
    animationSupported = window.requestAnimationFrame && !Util.osHasReducedMotion();
  if( expGalleries.length > 0 ) {
    var expGalleriesArray = [];
    for( var i = 0; i < expGalleries.length; i++) {
      (function(i){ expGalleriesArray.push(new ExpGallery(expGalleries[i]));})(i);

      // Lightbox gallery navigation with keyboard
      window.addEventListener('keydown', function(event){
        if(event.keyCode && event.keyCode == 39 || event.key && event.key.toLowerCase() == 'arrowright') {
          updateLightbox('next');
        } else if(event.keyCode && event.keyCode == 37 || event.key && event.key.toLowerCase() == 'arrowleft') {
          updateLightbox('prev');
        }
      });

      function updateLightbox(direction) {
        for( var i = 0; i < expGalleriesArray.length; i++) {
          (function(i){keyboardNavigateLightbox(expGalleriesArray[i], direction);})(i);
        };
      };
    }
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
// File#: _3_select-autocomplete
// Usage: codyhouse.co/license
(function() {
  var SelectAuto = function(element) {
    this.element = element;
    this.input = this.element.getElementsByClassName('js-autocomplete__input');
    this.resetBtn = this.element.getElementsByClassName('js-select-auto__input-btn');
    this.select = this.element.getElementsByClassName('js-select-auto__select');
    this.selectedValue = false; // value of the <option> the user selected
    this.selectOptions = []; // autocomplete list extracted from the <select> element
    this.focusOutId = false; // keep track of focus status
    this.autocompleteResults = this.element.getElementsByClassName('js-autocomplete__results');
    initSelectAuto(this);
  };

  function initSelectAuto(element) {
    if(element.select.length == 0) return;
    initDataResults(element); // populate autocomplete list
    Util.addClass(element.select[0], 'is-hidden'); // hide native <select> element
    initAutocomplete(element);
    initSelectAutoEvents(element);
  };

  function initDataResults(element) {
    // create the list of possible results based on the <select> input
    var optgroups = element.select[0].getElementsByTagName('optgroup');
    if(optgroups.length > 0) {
      for(var i = 0; i < optgroups.length; i++) {
        pushOptgroup(element, optgroups[i]);
      }
    } else {
      // no <optgroup>s -> loop through <options>
      pushOptions(element, element.select[0].getElementsByTagName('option'));
    }
  };

  function pushOptgroup(element, optgroup) {
    // push <optgroup> item
    var item = {};
    item.label = optgroup.getAttribute('label');
    item.template = 'optgroup';
    item = setCustomData(item, optgroup);
    element.selectOptions.push(item);
    // now push <option>s
    pushOptions(element, optgroup.getElementsByTagName('option'));
  };

  function pushOptions(element, options) {
    for(var i = 0; i < options.length; i++) {
      pushSingleOption(element, options[i]);
    };
  };

  function pushSingleOption(element, option) {
    // do not push <option>s without a value
    if(!option.getAttribute('value')) return;
    var item = {};
    item.label = option.text;
    item.template = 'option';
    item.value = option.value;
    item = setCustomData(item, option);
    element.selectOptions.push(item);
  };

  function setCustomData(obj, element) {
    // get custom data-attributes added to <option>s/<optgroup>s and add them to the autocomplete list
    var dataset = element.dataset;
    for (var prop in dataset) {
      if (Object.prototype.hasOwnProperty.call(dataset, prop)) {
        obj[prop] = dataset[prop];
      }
    }
    return obj;
  };
  
  function initAutocomplete(element) {
    // CodyHouse Autocomplete component
    // more info: https://codyhouse.co/ds/components/info/autocomplete
    new Autocomplete({
      element: element.element,
      characters: 0,
      searchData: function(value, cb, eventType) {
        selectAutoSearch(element, value, cb, eventType);
      },
      onClick: function(option, obj, event, cb) {
        selectAutoClick(element, option, obj, event, cb);
      }
    });
  };

  function selectAutoSearch(element, query, cb, eventType) {
    // get search results
    // more info: https://codyhouse.co/ds/components/info/autocomplete#search-data

    if(eventType == 'focus') { 
      // show all results when input is first in focus
      var data = JSON.parse(JSON.stringify(element.selectOptions));
    } else {
      // filter results
      var data = element.selectOptions.filter(function(item){
        // return item if item['label'] contains 'query' or if it is an <optgroup>
        return (query == '' || item['template'] == 'optgroup') ? true : item['label'].toLowerCase().indexOf(query.toLowerCase()) > -1;
      });
  
      // remove empty <optgroup>s
      var i = data.length;
      while (i--) {
        if (data[i].template == 'optgroup' && ( i == data.length - 1 || data[i+1].template == 'optgroup') ) { 
          data.splice(i, 1);
        } 
      }
    }

    // add a custom class to the selected <option> in the autocomplete list
    for(var i = 0; i < data.length; i++) {
      if(element.selectedValue && data[i].value && data[i].value == element.selectedValue && data[i].template != 'optgroup') {
        data[i].class = 'select-auto__option--selected';
      } else if(data[i].class) {
        delete data[i].class;
      }
    }

    if(data.length == 0) { // fallback for no results found
      data = [{
        label: 'No results',
        template: 'no-results'
      }];
    }

    // required by the Autocomplete component
    cb(data);
  };

  function selectAutoClick(element, option, obj, event, cb) {
    // an option in the autocomplete list has been selected
    if(option.getAttribute('data-autocomplete-template') != 'option') return;
    // get selected value + selected label
    var value = option.querySelector('[data-autocomplete-value]').innerText;
    var label = option.querySelector('[data-autocomplete-label]').innerText;
    resetSelectAuto(element, value, label);
    cb(); // this closes the autocomplete
  };

  function initSelectAutoEvents(element) {
    // on focus out -> reset input to initial value or to '' if the option was not selected
    element.input[0].addEventListener('focusout', function(event) {
      if(element.focusOutId) clearTimeout(element.focusOutId);
      element.focusOutId = setTimeout(function(){
        if(!element.element.contains(document.activeElement) || element.resetBtn[0].contains(document.activeElement)) {
          checkSelectAuto(element);
        }
      }, 100);
    });

    // when clicking on x -> reset selection to false
    if(element.resetBtn.length > 0) {
      element.resetBtn[0].addEventListener('click', function(event) {
        event.preventDefault();
        resetSelectAuto(element, false, '');
        element.input[0].focus();
      });
    }
  };

  function checkSelectAuto(element) {
    // check if we need to reset the value of the autocomplete input -> used when input loses focus
    var selectedLabel = !element.selectedValue ? '' : element.select[0].options[element.select[0].selectedIndex].text;
    if(element.input[0].value == selectedLabel) return;
    
    // user typed one of the possible options
    var optionInList = optionSelectedInList(element);
    if(optionInList[0]) {
      // update <select> element and return
      resetSelectAuto(element, optionInList[2], optionInList[1]);
      return;
    }

    (element.input[0].value == '') 
      ? resetSelectAuto(element, false, '')
      : resetSelectAuto(element, element.selectedValue, selectedLabel);
  };

  function optionSelectedInList(element) {
    var inList = false,
      label = '',
      value = false;
    for(var i = 0; i < element.selectOptions.length; i++) {
      if(element.selectOptions[i].template == 'option' && element.selectOptions[i].label.toLowerCase() == element.input[0].value.toLowerCase()) {
        inList = true;
        label = element.selectOptions[i].label;
        value = element.selectOptions[i].value;
        break;
      }
    }
    return [inList, label, value];
  };

  function resetSelectAuto(element, value, label) {
    // a new <option> has been selected
    element.input[0].value = label;
    element.selectedValue = value;
    Util.toggleClass(element.element, 'select-auto--selection-done', value);
    if(value === false) { // no value set
      element.select[0].selectedIndex = -1;
    } else { 
      element.select[0].value = value;
    }
    element.select[0].dispatchEvent(new Event('change'));
  };

  window.SelectAuto = SelectAuto;

  // init the SelectAuto object
  var selectAuto = document.getElementsByClassName('js-select-auto');
  if( selectAuto.length > 0 ) {
    for( var i = 0; i < selectAuto.length; i++) {
      (function(i){new SelectAuto(selectAuto[i]);})(i);
    }
  }
}());