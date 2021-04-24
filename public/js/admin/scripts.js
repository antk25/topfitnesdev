// Utility function
function Util () {};

/* 
	class manipulation functions
*/
Util.hasClass = function(el, className) {
	if (el.classList) return el.classList.contains(className);
	else return !!el.getAttribute('class').match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
};

Util.addClass = function(el, className) {
	var classList = className.split(' ');
 	if (el.classList) el.classList.add(classList[0]);
  else if (!Util.hasClass(el, classList[0])) el.setAttribute('class', el.getAttribute('class') +  " " + classList[0]);
 	if (classList.length > 1) Util.addClass(el, classList.slice(1).join(' '));
};

Util.removeClass = function(el, className) {
	var classList = className.split(' ');
	if (el.classList) el.classList.remove(classList[0]);	
	else if(Util.hasClass(el, classList[0])) {
		var reg = new RegExp('(\\s|^)' + classList[0] + '(\\s|$)');
    el.setAttribute('class', el.getAttribute('class').replace(reg, ' '));
	}
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
  for (var i = 0; i < el.children.length; i++) {
    if (Util.hasClass(el.children[i], className)) childrenByClass.push(el.children[i]);
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
// File#: _1_alert
// Usage: codyhouse.co/license
(function () {
    var alertClose = document.getElementsByClassName('js-alert__close-btn');
    if (alertClose.length > 0) {
        for (var i = 0; i < alertClose.length; i++) {
            (function (i) { initAlertEvent(alertClose[i]); })(i);
        }
    };
}());

function initAlertEvent(element) {
    element.addEventListener('click', function (event) {
        event.preventDefault();
        Util.removeClass(element.closest('.js-alert'), 'alert--is-visible');
    });
};
// File#: _1_character-count
// Usage: codyhouse.co/license
(function () {
    var CharacterCount = function (element) {
        this.element = element;
        this.input = this.element.getElementsByClassName('js-character-count__input')[0];
        this.characterLimit = Number(this.input.getAttribute('maxlength')) || 200;
        this.counter = this.element.getElementsByClassName('js-character-count__counter')[0];
        this.initCount();
    };

    CharacterCount.prototype.initCount = function () {
        var self = this;
        this.counter.textContent = this.getCount();//set counter value 
        this.input.addEventListener('input', function (event) { //listen for content changes
            self.counter.textContent = self.getCount();
        });
    };

    CharacterCount.prototype.getCount = function () {
        return this.characterLimit - this.input.value.length;
    };

    //initialize the CharacterCount objects
    var characterCounts = document.getElementsByClassName('js-character-count');
    if (characterCounts.length > 0) {
        for (var i = 0; i < characterCounts.length; i++) {
            (function (i) { new CharacterCount(characterCounts[i]); })(i);
        }
    };
}());
// File#: _1_choice-tags
// Usage: codyhouse.co/license
(function() {
    var ChoiceTags = function(element) {
      this.element = element;
      this.labels = this.element.getElementsByClassName('js-choice-tag');
      this.inputs = getChoiceInput(this);
      this.isRadio = this.inputs[0].type.toString() == 'radio';
      this.checkedClass = 'choice-tag--checked';
      initChoiceTags(this);
      initChoiceTagEvent(this);
    }
  
    function getChoiceInput(element) {
      var inputs = [];
      for(var i = 0; i < element.labels.length; i++) {
        inputs.push(element.labels[i].getElementsByTagName('input')[0]);
      }
      return inputs;
    };
  
    function initChoiceTags(element) {
      // if tag is selected by default - add checkedClass to the label element
      for(var i = 0; i < element.inputs.length; i++) {
        Util.toggleClass(element.labels[i], element.checkedClass, element.inputs[i].checked);
      }
    };
  
    function initChoiceTagEvent(element) {
      element.element.addEventListener('change', function(event) {
        var inputIndex = Util.getIndexInArray(element.inputs, event.target);
        if(inputIndex < 0) return;
        Util.toggleClass(element.labels[inputIndex], element.checkedClass, event.target.checked);
        if(element.isRadio && event.target.checked) resetRadioTags(element, inputIndex);
      });
    };
  
    function resetRadioTags(element, index) {
      // when a radio input is checked - reset all the others
      for(var i = 0; i < element.labels.length; i++) {
        if(i != index) Util.removeClass(element.labels[i], element.checkedClass);
      }
    };
  
    //initialize the ChoiceTags objects
    var choiceTags = document.getElementsByClassName('js-choice-tags');
    if( choiceTags.length > 0 ) {
      for( var i = 0; i < choiceTags.length; i++) {
        (function(i){new ChoiceTags(choiceTags[i]);})(i);
      }
    };
  }());
// File#: _1_circular-progress-bar
// Usage: codyhouse.co/license
(function() {	
  var CProgressBar = function(element) {
    this.element = element;
    this.fill = this.element.getElementsByClassName('c-progress-bar__fill')[0];
    this.fillLength = getProgressBarFillLength(this);
    this.label = this.element.getElementsByClassName('js-c-progress-bar__value');
    this.value = parseFloat(this.element.getAttribute('data-progress'));
    // before checking if data-animation is set -> check for reduced motion
    updatedProgressBarForReducedMotion(this);
    this.animate = this.element.hasAttribute('data-animation') && this.element.getAttribute('data-animation') == 'on';
    this.animationDuration = this.element.hasAttribute('data-duration') ? this.element.getAttribute('data-duration') : 1000;
    // animation will run only on browsers supporting IntersectionObserver
    this.canAnimate = ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype);
    // this element is used to announce the percentage value to SR
    this.ariaLabel = this.element.getElementsByClassName('js-c-progress-bar__aria-value');
    // check if we need to update the bar color
    this.changeColor =  Util.hasClass(this.element, 'c-progress-bar--color-update') && Util.cssSupports('color', 'var(--color-value)');
    if(this.changeColor) {
      this.colorThresholds = getProgressBarColorThresholds(this);
    }
    initProgressBar(this);
    // store id to reset animation
    this.animationId = false;
  };

  // public function
  CProgressBar.prototype.setProgressBarValue = function(value) {
    setProgressBarValue(this, value);
  };

  function getProgressBarFillLength(progressBar) {
    return parseFloat(2*Math.PI*progressBar.fill.getAttribute('r')).toFixed(2);
  };

  function getProgressBarColorThresholds(progressBar) {
    var thresholds = [];
    var i = 1;
    while (!isNaN(parseInt(getComputedStyle(progressBar.element).getPropertyValue('--c-progress-bar-color-'+i)))) {
      thresholds.push(parseInt(getComputedStyle(progressBar.element).getPropertyValue('--c-progress-bar-color-'+i)));
      i = i + 1;
    }
    return thresholds;
  };

  function updatedProgressBarForReducedMotion(progressBar) {
    // if reduced motion is supported and set to reduced -> remove animations
    if(osHasReducedMotion) progressBar.element.removeAttribute('data-animation');
  };

  function initProgressBar(progressBar) {
    // set shape initial dashOffset
    setShapeOffset(progressBar);
    // set initial bar color
    if(progressBar.changeColor) updateProgressBarColor(progressBar, progressBar.value);
    // if data-animation is on -> reset the progress bar and animate when entering the viewport
    if(progressBar.animate && progressBar.canAnimate) animateProgressBar(progressBar);
    else setProgressBarValue(progressBar, progressBar.value);
    // reveal fill and label -> --animate and --color-update variations only
    setTimeout(function(){Util.addClass(progressBar.element, 'c-progress-bar--init');}, 30);

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

  function setShapeOffset(progressBar) {
    var center = progressBar.fill.getAttribute('cx');
    progressBar.fill.setAttribute('transform', "rotate(-90 "+center+" "+center+")");
    progressBar.fill.setAttribute('stroke-dashoffset', progressBar.fillLength);
    progressBar.fill.setAttribute('stroke-dasharray', progressBar.fillLength);
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

  function setProgressBarValue(progressBar, value) {
    var offset = ((100 - value)*progressBar.fillLength/100).toFixed(2);
    progressBar.fill.setAttribute('stroke-dashoffset', offset);
    if(progressBar.label.length > 0 ) progressBar.label[0].textContent = value;
    if(progressBar.changeColor) updateProgressBarColor(progressBar, value);
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

  function updateProgressBarColor(progressBar, value) {
    var className = 'c-progress-bar--fill-color-'+ progressBar.colorThresholds.length;
    for(var i = progressBar.colorThresholds.length; i > 0; i--) {
      if( !isNaN(progressBar.colorThresholds[i - 1]) && value <= progressBar.colorThresholds[i - 1]) {
        className = 'c-progress-bar--fill-color-' + i;
      } 
    }
    
    removeProgressBarColorClasses(progressBar);
    Util.addClass(progressBar.element, className);
  };

  function removeProgressBarColorClasses(progressBar) {
    var classes = progressBar.element.className.split(" ").filter(function(c) {
      return c.lastIndexOf('c-progress-bar--fill-color-', 0) !== 0;
    });
    progressBar.element.className = classes.join(" ").trim();
  };

  function getProgressBarValue(progressBar) {
    return (100 - Math.round((parseFloat(progressBar.fill.getAttribute('stroke-dashoffset'))/progressBar.fillLength)*100));
  };

  function emitProgressBarEvents(progressBar, eventName, detail) {
    progressBar.element.dispatchEvent(new CustomEvent(eventName, {detail: detail}));
  };

  window.CProgressBar = CProgressBar;

  //initialize the CProgressBar objects
  var circularProgressBars = document.getElementsByClassName('js-c-progress-bar');
  var osHasReducedMotion = Util.osHasReducedMotion();
  if( circularProgressBars.length > 0 ) {
    for( var i = 0; i < circularProgressBars.length; i++) {
      (function(i){new CProgressBar(circularProgressBars[i]);})(i);
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
  
  

// File#: _1_dialog
// Usage: codyhouse.co/license
(function () {
    var Dialog = function (element) {
        this.element = element;
        this.triggers = document.querySelectorAll('[aria-controls="' + this.element.getAttribute('id') + '"]');
        this.firstFocusable = null;
        this.lastFocusable = null;
        this.selectedTrigger = null;
        this.showClass = "dialog--is-visible";
        initDialog(this);
    };

    function initDialog(dialog) {
        if (dialog.triggers) {
            for (var i = 0; i < dialog.triggers.length; i++) {
                dialog.triggers[i].addEventListener('click', function (event) {
                    event.preventDefault();
                    dialog.selectedTrigger = event.target;
                    showDialog(dialog);
                    initDialogEvents(dialog);
                });
            }
        }

        // listen to the openDialog event -> open dialog without a trigger button
        dialog.element.addEventListener('openDialog', function (event) {
            if (event.detail) self.selectedTrigger = event.detail;
            showDialog(dialog);
            initDialogEvents(dialog);
        });
    };

    function showDialog(dialog) {
        Util.addClass(dialog.element, dialog.showClass);
        getFocusableElements(dialog);
        dialog.firstFocusable.focus();
        // wait for the end of transitions before moving focus
        dialog.element.addEventListener("transitionend", function cb(event) {
            dialog.firstFocusable.focus();
            dialog.element.removeEventListener("transitionend", cb);
        });
        emitDialogEvents(dialog, 'dialogIsOpen');
    };

    function closeDialog(dialog) {
        Util.removeClass(dialog.element, dialog.showClass);
        dialog.firstFocusable = null;
        dialog.lastFocusable = null;
        if (dialog.selectedTrigger) dialog.selectedTrigger.focus();
        //remove listeners
        cancelDialogEvents(dialog);
        emitDialogEvents(dialog, 'dialogIsClose');
    };

    function initDialogEvents(dialog) {
        //add event listeners
        dialog.element.addEventListener('keydown', handleEvent.bind(dialog));
        dialog.element.addEventListener('click', handleEvent.bind(dialog));
    };

    function cancelDialogEvents(dialog) {
        //remove event listeners
        dialog.element.removeEventListener('keydown', handleEvent.bind(dialog));
        dialog.element.removeEventListener('click', handleEvent.bind(dialog));
    };

    function handleEvent(event) {
        // handle events
        switch (event.type) {
            case 'click': {
                initClick(this, event);
            }
            case 'keydown': {
                initKeyDown(this, event);
            }
        }
    };

    function initKeyDown(dialog, event) {
        if (event.keyCode && event.keyCode == 27 || event.key && event.key == 'Escape') {
            //close dialog on esc
            closeDialog(dialog);
        } else if (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab') {
            //trap focus inside dialog
            trapFocus(dialog, event);
        }
    };

    function initClick(dialog, event) {
        //close dialog when clicking on close button
        if (!event.target.closest('.js-dialog__close')) return;
        event.preventDefault();
        closeDialog(dialog);
    };

    function trapFocus(dialog, event) {
        if (dialog.firstFocusable == document.activeElement && event.shiftKey) {
            //on Shift+Tab -> focus last focusable element when focus moves out of dialog
            event.preventDefault();
            dialog.lastFocusable.focus();
        }
        if (dialog.lastFocusable == document.activeElement && !event.shiftKey) {
            //on Tab -> focus first focusable element when focus moves out of dialog
            event.preventDefault();
            dialog.firstFocusable.focus();
        }
    };

    function getFocusableElements(dialog) {
        //get all focusable elements inside the dialog
        var allFocusable = dialog.element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary');
        getFirstVisible(dialog, allFocusable);
        getLastVisible(dialog, allFocusable);
    };

    function getFirstVisible(dialog, elements) {
        //get first visible focusable element inside the dialog
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length) {
                dialog.firstFocusable = elements[i];
                return true;
            }
        }
    };

    function getLastVisible(dialog, elements) {
        //get last visible focusable element inside the dialog
        for (var i = elements.length - 1; i >= 0; i--) {
            if (elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length) {
                dialog.lastFocusable = elements[i];
                return true;
            }
        }
    };

    function emitDialogEvents(dialog, eventName) {
        var event = new CustomEvent(eventName, { detail: dialog.selectedTrigger });
        dialog.element.dispatchEvent(event);
    };

    //initialize the Dialog objects
    var dialogs = document.getElementsByClassName('js-dialog');
    if (dialogs.length > 0) {
        for (var i = 0; i < dialogs.length; i++) {
            (function (i) { new Dialog(dialogs[i]); })(i);
        }
    }
}());
// File#: _1_drawer
// Usage: codyhouse.co/license
(function() {
	var Drawer = function(element) {
		this.element = element;
		this.content = document.getElementsByClassName('js-drawer__body')[0];
		this.triggers = document.querySelectorAll('[aria-controls="'+this.element.getAttribute('id')+'"]');
		this.firstFocusable = null;
		this.lastFocusable = null;
		this.selectedTrigger = null;
		this.isModal = Util.hasClass(this.element, 'js-drawer--modal');
		this.showClass = "drawer--is-visible";
		this.initDrawer();
	};

	Drawer.prototype.initDrawer = function() {
		var self = this;
		//open drawer when clicking on trigger buttons
		if ( this.triggers ) {
			for(var i = 0; i < this.triggers.length; i++) {
				this.triggers[i].addEventListener('click', function(event) {
					event.preventDefault();
					if(Util.hasClass(self.element, self.showClass)) {
						self.closeDrawer(event.target);
						return;
					}
					self.selectedTrigger = event.target;
					self.showDrawer();
					self.initDrawerEvents();
				});
			}
		}

		// if drawer is already open -> we should initialize the drawer events
		if(Util.hasClass(this.element, this.showClass)) this.initDrawerEvents();
	};

	Drawer.prototype.showDrawer = function() {
		var self = this;
		this.content.scrollTop = 0;
		Util.addClass(this.element, this.showClass);
		this.getFocusableElements();
		Util.moveFocus(this.element);
		// wait for the end of transitions before moving focus
		this.element.addEventListener("transitionend", function cb(event) {
			Util.moveFocus(self.element);
			self.element.removeEventListener("transitionend", cb);
		});
		this.emitDrawerEvents('drawerIsOpen', this.selectedTrigger);
	};

	Drawer.prototype.closeDrawer = function(target) {
		Util.removeClass(this.element, this.showClass);
		this.firstFocusable = null;
		this.lastFocusable = null;
		if(this.selectedTrigger) this.selectedTrigger.focus();
		//remove listeners
		this.cancelDrawerEvents();
		this.emitDrawerEvents('drawerIsClose', target);
	};

	Drawer.prototype.initDrawerEvents = function() {
		//add event listeners
		this.element.addEventListener('keydown', this);
		this.element.addEventListener('click', this);
	};

	Drawer.prototype.cancelDrawerEvents = function() {
		//remove event listeners
		this.element.removeEventListener('keydown', this);
		this.element.removeEventListener('click', this);
	};

	Drawer.prototype.handleEvent = function (event) {
		switch(event.type) {
			case 'click': {
				this.initClick(event);
			}
			case 'keydown': {
				this.initKeyDown(event);
			}
		}
	};

	Drawer.prototype.initKeyDown = function(event) {
		if( event.keyCode && event.keyCode == 27 || event.key && event.key == 'Escape' ) {
			//close drawer window on esc
			this.closeDrawer(false);
		} else if( this.isModal && (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab' )) {
			//trap focus inside drawer
			this.trapFocus(event);
		}
	};

	Drawer.prototype.initClick = function(event) {
		//close drawer when clicking on close button or drawer bg layer 
		if( !event.target.closest('.js-drawer__close') && !Util.hasClass(event.target, 'js-drawer') ) return;
		event.preventDefault();
		this.closeDrawer(event.target);
	};

	Drawer.prototype.trapFocus = function(event) {
		if( this.firstFocusable == document.activeElement && event.shiftKey) {
			//on Shift+Tab -> focus last focusable element when focus moves out of drawer
			event.preventDefault();
			this.lastFocusable.focus();
		}
		if( this.lastFocusable == document.activeElement && !event.shiftKey) {
			//on Tab -> focus first focusable element when focus moves out of drawer
			event.preventDefault();
			this.firstFocusable.focus();
		}
	}

	Drawer.prototype.getFocusableElements = function() {
		//get all focusable elements inside the drawer
		var allFocusable = this.element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary');
		this.getFirstVisible(allFocusable);
		this.getLastVisible(allFocusable);
	};

	Drawer.prototype.getFirstVisible = function(elements) {
		//get first visible focusable element inside the drawer
		for(var i = 0; i < elements.length; i++) {
			if( elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length ) {
				this.firstFocusable = elements[i];
				return true;
			}
		}
	};

	Drawer.prototype.getLastVisible = function(elements) {
		//get last visible focusable element inside the drawer
		for(var i = elements.length - 1; i >= 0; i--) {
			if( elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length ) {
				this.lastFocusable = elements[i];
				return true;
			}
		}
	};

	Drawer.prototype.emitDrawerEvents = function(eventName, target) {
		var event = new CustomEvent(eventName, {detail: target});
		this.element.dispatchEvent(event);
	};

	//initialize the Drawer objects
	var drawer = document.getElementsByClassName('js-drawer');
	if( drawer.length > 0 ) {
		for( var i = 0; i < drawer.length; i++) {
			(function(i){new Drawer(drawer[i]);})(i);
		}
	}
}());
// File#: _1_expandable-search
// Usage: codyhouse.co/license
(function() {
	var expandableSearch = document.getElementsByClassName('js-expandable-search');
	if(expandableSearch.length > 0) {
		for( var i = 0; i < expandableSearch.length; i++) {
			(function(i){ // if user types in search input, keep the input expanded when focus is lost
				expandableSearch[i].getElementsByClassName('js-expandable-search__input')[0].addEventListener('input', function(event){
					Util.toggleClass(event.target, 'expandable-search__input--has-content', event.target.value.length > 0);
				});
			})(i);
		}
	}
}());
// File#: _1_flash-message
// Usage: codyhouse.co/license
(function () {
    var FlashMessage = function (element) {
        this.element = element;
        this.showClass = "flash-message--is-visible";
        this.messageDuration = parseInt(this.element.getAttribute('data-duration')) || 3000;
        this.triggers = document.querySelectorAll('[aria-controls="' + this.element.getAttribute('id') + '"]');
        this.temeoutId = null;
        this.isVisible = false;
        this.initFlashMessage();
    };

    FlashMessage.prototype.initFlashMessage = function () {
        var self = this;
        //open modal when clicking on trigger buttons
        if (self.triggers) {
            for (var i = 0; i < self.triggers.length; i++) {
                self.triggers[i].addEventListener('click', function (event) {
                    event.preventDefault();
                    self.showFlashMessage();
                });
            }
        }
        //listen to the event that triggers the opening of a flash message
        self.element.addEventListener('showFlashMessage', function () {
            self.showFlashMessage();
        });
    };

    FlashMessage.prototype.showFlashMessage = function () {
        var self = this;
        Util.addClass(self.element, self.showClass);
        self.isVisible = true;
        //hide other flash messages
        self.hideOtherFlashMessages();
        if (self.messageDuration > 0) {
            //hide the message after an interveal (this.messageDuration)
            self.temeoutId = setTimeout(function () {
                self.hideFlashMessage();
            }, self.messageDuration);
        }
    };

    FlashMessage.prototype.hideFlashMessage = function () {
        Util.removeClass(this.element, this.showClass);
        this.isVisible = false;
        //reset timeout
        clearTimeout(this.temeoutId);
        this.temeoutId = null;
    };

    FlashMessage.prototype.hideOtherFlashMessages = function () {
        var event = new CustomEvent('flashMessageShown', { detail: this.element });
        window.dispatchEvent(event);
    };

    FlashMessage.prototype.checkFlashMessage = function (message) {
        if (!this.isVisible) return;
        if (this.element == message) return;
        this.hideFlashMessage();
    };

    //initialize the FlashMessage objects
    var flashMessages = document.getElementsByClassName('js-flash-message');
    if (flashMessages.length > 0) {
        var flashMessagesArray = [];
        for (var i = 0; i < flashMessages.length; i++) {
            (function (i) { flashMessagesArray.push(new FlashMessage(flashMessages[i])); })(i);
        }

        //listen for a flash message to be shown -> close the others
        window.addEventListener('flashMessageShown', function (event) {
            flashMessagesArray.forEach(function (element) {
                element.checkFlashMessage(event.detail);
            });
        });
    }
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
// File#: _1_number-input
// Usage: codyhouse.co/license
(function () {
    var InputNumber = function (element) {
        this.element = element;
        this.input = this.element.getElementsByClassName('js-number-input__value')[0];
        this.min = parseFloat(this.input.getAttribute('min'));
        this.max = parseFloat(this.input.getAttribute('max'));
        this.step = parseFloat(this.input.getAttribute('step'));
        if (isNaN(this.step)) this.step = 1;
        this.precision = getStepPrecision(this.step);
        initInputNumberEvents(this);
    };

    function initInputNumberEvents(input) {
        // listen to the click event on the custom increment buttons
        input.element.addEventListener('click', function (event) {
            var increment = event.target.closest('.js-number-input__btn');
            if (increment) {
                event.preventDefault();
                updateInputNumber(input, increment);
            }
        });

        // when input changes, make sure the new value is acceptable
        input.input.addEventListener('focusout', function (event) {
            var value = parseFloat(input.input.value);
            if (value < input.min) value = input.min;
            if (value > input.max) value = input.max;
            // check value is multiple of step
            value = checkIsMultipleStep(input, value);
            if (value != parseFloat(input.input.value)) input.input.value = value;

        });
    };

    function getStepPrecision(step) {
        // if step is a floating number, return its precision
        return (step.toString().length - Math.floor(step).toString().length - 1);
    };

    function updateInputNumber(input, btn) {
        var value = (Util.hasClass(btn, 'number-input__btn--plus')) ? parseFloat(input.input.value) + input.step : parseFloat(input.input.value) - input.step;
        if (input.precision > 0) value = value.toFixed(input.precision);
        if (value < input.min) value = input.min;
        if (value > input.max) value = input.max;
        input.input.value = value;
        input.input.dispatchEvent(new CustomEvent('change', { bubbles: true })); // trigger change event
    };

    function checkIsMultipleStep(input, value) {
        // check if the number inserted is a multiple of the step value
        var remain = (value * 10 * input.precision) % (input.step * 10 * input.precision);
        if (remain != 0) value = value - remain;
        if (input.precision > 0) value = value.toFixed(input.precision);
        return value;
    };

    //initialize the InputNumber objects
    var inputNumbers = document.getElementsByClassName('js-number-input');
    if (inputNumbers.length > 0) {
        for (var i = 0; i < inputNumbers.length; i++) {
            (function (i) { new InputNumber(inputNumbers[i]); })(i);
        }
    }
}());
// File#: _1_rating
// Usage: codyhouse.co/license
(function () {
	var Rating = function (element) {
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

	Rating.prototype.getInitialRating = function () {
		// get the rating of the product
		if (!this.initialRatingElement || !this.readOnly) {
			this.initialRating = [0, false];
			return;
		}

		var initialValue = Number(this.initialRatingElement.textContent);
		if (isNaN(initialValue)) {
			this.initialRating = [0, false];
			return;
		}

		var floorNumber = Math.floor(initialValue);
		this.initialRating[0] = (floorNumber < initialValue) ? floorNumber + 1 : floorNumber;
		this.initialRating[1] = (floorNumber < initialValue) ? Math.round((initialValue - floorNumber) * 100) : false;
	};

	Rating.prototype.initRatingHtml = function () {
		//create the star elements
		var iconsList = this.readOnly ? '<ul>' : '<ul role="radiogroup">';

		//if initial rating value is zero -> add a 'zero' item 
		if (this.initialRating[0] == 0 && !this.initialRating[1]) {
			iconsList = iconsList + '<li class="rating__item--zero rating__item--checked"></li>';
		}

		// create the stars list 
		for (var i = 0; i < this.ratingMaxValue; i++) {
			iconsList = iconsList + this.getStarHtml(i);
		}
		iconsList = iconsList + '</ul>';

		// --default variation only - improve SR accessibility including a legend element 
		if (!this.readOnly) {
			var labelElement = this.element.getElementsByTagName('label');
			if (labelElement.length > 0) {
				var legendElement = '<legend class="' + labelElement[0].getAttribute('class') + '">' + labelElement[0].textContent + '</legend>';
				iconsList = '<fieldset>' + legendElement + iconsList + '</fieldset>';
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

	Rating.prototype.getStarHtml = function (index) {
		var listItem = '';
		var checked = (index + 1 == this.initialRating[0]) ? true : false,
			itemClass = checked ? ' rating__item--checked' : '',
			tabIndex = (checked || (this.initialRating[0] == 0 && !this.initialRating[1] && index == 0)) ? 0 : -1,
			showHalf = checked && this.initialRating[1] ? true : false,
			iconWidth = showHalf ? ' rating__item--half' : '';
		if (!this.readOnly) {
			listItem = '<li class="js-rating__item' + itemClass + iconWidth + '" role="radio" aria-label="' + (index + 1) + '" aria-checked="' + checked + '" tabindex="' + tabIndex + '"><div class="rating__icon">' + this.iconCode + '</div></li>';
		} else {
			var starInner = showHalf ? '<div class="rating__icon">' + this.iconCode + '</div><div class="rating__icon rating__icon--inactive">' + this.iconCode + '</div>' : '<div class="rating__icon">' + this.iconCode + '</div>';
			listItem = '<li class="js-rating__item' + itemClass + iconWidth + '">' + starInner + '</li>';
		}
		return listItem;
	};

	Rating.prototype.initRatingEvents = function () {
		var self = this;

		//click on a star
		this.icons.addEventListener('click', function (event) {
			var trigger = event.target.closest('.js-rating__item');
			self.resetSelectedIcon(trigger);
		});

		//keyboard navigation -> select new star
		this.icons.addEventListener('keydown', function (event) {
			if (event.keyCode && (event.keyCode == 39 || event.keyCode == 40) || event.key && (event.key.toLowerCase() == 'arrowright' || event.key.toLowerCase() == 'arrowdown')) {
				self.selectNewIcon('next'); //select next star on arrow right/down
			} else if (event.keyCode && (event.keyCode == 37 || event.keyCode == 38) || event.key && (event.key.toLowerCase() == 'arrowleft' || event.key.toLowerCase() == 'arrowup')) {
				self.selectNewIcon('prev'); //select prev star on arrow left/up
			} else if (event.keyCode && event.keyCode == 32 || event.key && event.key == ' ') {
				self.selectFocusIcon(); // select focused star on Space
			}
		});
	};

	Rating.prototype.selectNewIcon = function (direction) {
		var index = Util.getIndexInArray(this.ratingItems, this.selectedRatingItem);
		index = (direction == 'next') ? index + 1 : index - 1;
		if (index < 0) index = this.ratingItems.length - 1;
		if (index >= this.ratingItems.length) index = 0;
		this.resetSelectedIcon(this.ratingItems[index]);
		this.ratingItems[index].focus();
	};

	Rating.prototype.selectFocusIcon = function (direction) {
		this.resetSelectedIcon(document.activeElement);
	};

	Rating.prototype.resetSelectedIcon = function (trigger) {
		if (!trigger) return;
		Util.removeClass(this.selectedRatingItem, 'rating__item--checked');
		Util.setAttributes(this.selectedRatingItem, { 'aria-checked': false, 'tabindex': -1 });
		Util.addClass(trigger, 'rating__item--checked');
		Util.setAttributes(trigger, { 'aria-checked': true, 'tabindex': 0 });
		this.selectedRatingItem = trigger;
		// update select input value
		var select = this.element.getElementsByTagName('select');
		if (select.length > 0) {
			select[0].value = trigger.getAttribute('aria-label');
		}
	};

	//initialize the Rating objects
	var ratings = document.getElementsByClassName('js-rating');
	if (ratings.length > 0) {
		for (var i = 0; i < ratings.length; i++) {
			(function (i) { new Rating(ratings[i]); })(i);
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
// File#: _1_repeater
// Usage: codyhouse.co/license
(function () {
    var Repeater = function (element) {
        this.element = element;
        this.blockWrapper = this.element.getElementsByClassName('js-repeater__list');
        if (this.blockWrapper.length < 1) return;
        this.blocks = false;
        getBlocksList(this);
        this.firstBlock = false;
        this.addNew = this.element.getElementsByClassName('js-repeater__add');
        this.cloneClass = this.element.getAttribute('data-repeater-class');
        this.inputName = this.element.getAttribute('data-repeater-input-name');
        initRepeater(this);
    };

    function initRepeater(element) {
        if (element.addNew.length < 1 || element.blocks.length < 1 || element.blockWrapper.length < 1) return;
        element.firstBlock = element.blocks[0].cloneNode(true);

        // detect click on a Remove button
        element.element.addEventListener('click', function (event) {
            var deleteBtn = event.target.closest('.js-repeater__remove');
            if (deleteBtn) {
                event.preventDefault();
                removeBlock(element, deleteBtn);
            }
        });

        // detect click on Add button
        element.addNew[0].addEventListener('click', function (event) {
            event.preventDefault();
            addBlock(element);
        });
    };

    function addBlock(element) {
        if (element.blocks.length > 0) {
            var clone = element.blocks[element.blocks.length - 1].cloneNode(true),
                nameToReplace = element.inputName.replace('[n]', '[' + (element.blocks.length - 1) + ']'),
                newName = element.inputName.replace('[n]', '[' + element.blocks.length + ']');
        } else {
            var clone = element.firstBlock.cloneNode(true),
                nameToReplace = element.inputName.replace('[n]', '[0]'),
                newName = element.inputName.replace('[n]', '[0]');
        }

        if (element.cloneClass) Util.addClass(clone, element.cloneClass);
        // modify name/for/id attributes
        updateBlockAttrs(clone, nameToReplace, newName, true);

        element.blockWrapper[0].appendChild(clone);
        // update blocks list
        getBlocksList(element)
    };

    function removeBlock(element, trigger) {
        var block = trigger.closest('.js-repeater__item');
        if (block) {
            var index = Util.getIndexInArray(element.blocks, block);
            block.remove();
            // update blocks list
            getBlocksList(element);
            // need to reset all blocks after that -> name/for/id values
            for (var i = index; i < element.blocks.length; i++) {
                updateBlockAttrs(element.blocks[i], element.inputName.replace('[n]', '[' + (i + 1) + ']'), element.inputName.replace('[n]', '[' + i + ']'));
            }
        }
    };

    function updateBlockAttrs(block, nameToReplace, newName, reset) {
        var nameElements = block.querySelectorAll('[name^="' + nameToReplace + '"]'),
            forElements = block.querySelectorAll('[for^="' + nameToReplace + '"]'),
            idElements = block.querySelectorAll('[id^="' + nameToReplace + '"]');

        for (var i = 0; i < nameElements.length; i++) {
            var nameAttr = nameElements[i].getAttribute('name');
            nameElements[i].setAttribute('name', nameAttr.replace(nameToReplace, newName));
            if (reset && nameElements[i].value) nameElements[i].value = '';
        }

        for (var i = 0; i < forElements.length; i++) {
            var forAttr = forElements[i].getAttribute('for');
            forElements[i].setAttribute('for', forAttr.replace(nameToReplace, newName));
        }

        for (var i = 0; i < idElements.length; i++) {
            var idAttr = idElements[i].getAttribute('id');
            idElements[i].setAttribute('id', idAttr.replace(nameToReplace, newName));
        }
    };

    function getBlocksList(element) {
        element.blocks = Util.getChildrenByClassName(element.blockWrapper[0], 'js-repeater__item');
    };

    //initialize the Repeater objects
    var repeater = document.getElementsByClassName('js-repeater');
    if (repeater.length > 0) {
        for (var i = 0; i < repeater.length; i++) {
            (function (i) { new Repeater(repeater[i]); })(i);
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
// File#: _1_side-navigation
// Usage: codyhouse.co/license
(function() {
  function initSideNav(nav) {
    nav.addEventListener('click', function(event){
      var btn = event.target.closest('.js-sidenav__sublist-control');
      if(!btn) return;
      var listItem = btn.parentElement,
        bool = Util.hasClass(listItem, 'sidenav__item--expanded');
      btn.setAttribute('aria-expanded', !bool);
      Util.toggleClass(listItem, 'sidenav__item--expanded', !bool);
    });
  };

	var sideNavs = document.getElementsByClassName('js-sidenav');
	if( sideNavs.length > 0 ) {
		for( var i = 0; i < sideNavs.length; i++) {
      (function(i){initSideNav(sideNavs[i]);})(i);
		}
	}
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
// File#: _1_table
// Usage: codyhouse.co/license
(function () {
    function initTable(table) {
        checkTableLayour(table); // switch from a collapsed to an expanded layout
        Util.addClass(table, 'table--loaded'); // show table

        // custom event emitted when window is resized
        table.addEventListener('update-table', function (event) {
            checkTableLayour(table);
        });
    };

    function checkTableLayour(table) {
        var layout = getComputedStyle(table, ':before').getPropertyValue('content').replace(/\'|"/g, '');
        Util.toggleClass(table, tableExpandedLayoutClass, layout != 'collapsed');
    };

    var tables = document.getElementsByClassName('js-table'),
        tableExpandedLayoutClass = 'table--expanded';
    if (tables.length > 0) {
        var j = 0;
        for (var i = 0; i < tables.length; i++) {
            var beforeContent = getComputedStyle(tables[i], ':before').getPropertyValue('content');
            if (beforeContent && beforeContent != '' && beforeContent != 'none') {
                (function (i) { initTable(tables[i]); })(i);
                j = j + 1;
            } else {
                Util.addClass(tables[i], 'table--loaded');
            }
        }

        if (j > 0) {
            var resizingId = false,
                customEvent = new CustomEvent('update-table');
            window.addEventListener('resize', function (event) {
                clearTimeout(resizingId);
                resizingId = setTimeout(doneResizing, 300);
            });

            function doneResizing() {
                for (var i = 0; i < tables.length; i++) {
                    (function (i) { tables[i].dispatchEvent(customEvent) })(i);
                };
            };

            (window.requestAnimationFrame) // init table layout
                ? window.requestAnimationFrame(doneResizing)
                : doneResizing();
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
// File#: _2_drag-drop-file
// Usage: codyhouse.co/license
(function () {
  var Ddf = function (opts) {
    this.options = Util.extend(Ddf.defaults, opts);
    this.element = this.options.element;
    this.area = this.element.getElementsByClassName('js-ddf__area');
    this.input = this.element.getElementsByClassName('js-ddf__input');
    this.label = this.element.getElementsByClassName('js-ddf__label');
    this.labelEnd = this.element.getElementsByClassName('js-ddf__files-counter');
    this.labelEndMessage = this.labelEnd.length > 0 ? this.labelEnd[0].innerHTML.split('%') : false;
    this.droppedFiles = [];
    this.lastDroppedFiles = [];
    this.options.acceptFile = [];
    this.progress = false;
    this.progressObj = [];
    this.progressCompleteClass = 'ddf__progress--complete';
    initDndMessageResponse(this);
    initProgress(this, 0, 1, false);
    initDdf(this);
  };

  function initDndMessageResponse(element) {
    // use this function to initilise the response of the Ddf when files are dropped (e.g., show list of files, update label message, show loader)
    if (element.options.showFiles) {
      element.filesList = element.element.getElementsByClassName('js-ddf__list');
      if (element.filesList.length == 0) return;
      element.fileItems = element.filesList[0].getElementsByClassName('js-ddf__item');
      if (element.fileItems.length > 0) Util.addClass(element.fileItems[0], 'is-hidden'); +
        // listen for click on remove file action
        initRemoveFile(element);
    } else { // do not show list of files
      if (element.label.length == 0) return;
      if (element.options.upload) element.progress = element.element.getElementsByClassName('js-ddf__progress');
    }
  };

  function initDdf(element) {
    if (element.input.length > 0) { // store accepted file format
      var accept = element.input[0].getAttribute('accept');
      if (accept) element.options.acceptFile = accept.split(',').map(function (element) { return element.trim(); })
    }

    initDndInput(element);
    initDndArea(element);
  };

  function initDndInput(element) { // listen to changes in the input file element
    if (element.input.length == 0) return;
    element.input[0].addEventListener('change', function (event) {
      if (element.input[0].value == '') return;
      storeDroppedFiles(element, element.input[0].files);
      element.input[0].value = '';
      updateDndArea(element);
    });
  };

  function initDndArea(element) { //drag event listeners
    element.element.addEventListener('dragenter', handleEvent.bind(element));
    element.element.addEventListener('dragover', handleEvent.bind(element));
    element.element.addEventListener('dragleave', handleEvent.bind(element));
    element.element.addEventListener('drop', handleEvent.bind(element));
  };

  function handleEvent(event) {
    switch (event.type) {
      case 'dragenter':
      case 'dragover':
        preventDefaults(event);
        Util.addClass(this.area[0], 'ddf__area--file-hover');
        break;
      case 'dragleave':
        preventDefaults(event);
        Util.removeClass(this.area[0], 'ddf__area--file-hover');
        break;
      case 'drop':
        preventDefaults(event);
        storeDroppedFiles(this, event.dataTransfer.files);
        updateDndArea(this);
        break;
    }
  };

  function storeDroppedFiles(element, fileData) { // check files size/format/number
    element.lastDroppedFiles = [];
    if (element.options.replaceFiles) element.droppedFiles = [];
    Array.prototype.push.apply(element.lastDroppedFiles, fileData);
    filterUploadedFiles(element); // remove files that do not respect format/size
    element.droppedFiles = element.droppedFiles.concat(element.lastDroppedFiles);
    if (element.options.maxFiles) filterMaxFiles(element); // check max number of files
  };

  function updateDndArea(element) { // update UI + emit events
    if (element.options.showFiles) updateDndList(element);
    else {
      updateDndAreaMessage(element);
      Util.addClass(element.area[0], 'ddf__area--file-dropped');
    }
    Util.removeClass(element.area[0], 'ddf__area--file-hover');
    emitCustomEvents(element, 'filesUploaded', false);
  };

  function preventDefaults(event) {
    event.preventDefault();
    event.stopPropagation();
  };

  function filterUploadedFiles(element) {
    // check max weight
    if (element.options.maxSize) filterMaxWeight(element);
    // check file format
    if (element.options.acceptFile.length > 0) filterAcceptFile(element);
  };

  function filterMaxWeight(element) { // filter files by size
    var rejected = [];
    for (var i = element.lastDroppedFiles.length - 1; i >= 0; i--) {
      if (element.lastDroppedFiles[i].size > element.options.maxSize * 1000) {
        var rejectedFile = element.lastDroppedFiles.splice(i, 1);
        rejected.push(rejectedFile[0].name);
      }
    }
    if (rejected.length > 0) {
      emitCustomEvents(element, 'rejectedWeight', rejected);
    }
  };

  function filterAcceptFile(element) { // filter files by format
    var rejected = [];
    for (var i = element.lastDroppedFiles.length - 1; i >= 0; i--) {
      if (!formatInList(element, i)) {
        var rejectedFile = element.lastDroppedFiles.splice(i, 1);
        rejected.push(rejectedFile[0].name);
      }
    }

    if (rejected.length > 0) {
      emitCustomEvents(element, 'rejectedFormat', rejected);
    }
  };

  function formatInList(element, index) {
    var formatArray = element.lastDroppedFiles[index].type.split('/'),
      type = formatArray[0] + '/*',
      extension = formatArray.length > 1 ? formatArray[1] : false;

    var accepted = false;
    for (var i = 0; i < element.options.acceptFile.length; i++) {
      if (element.lastDroppedFiles[index].type == element.options.acceptFile[i] || type == element.options.acceptFile[i] || (extension && extension == element.options.acceptFile[i])) {
        accepted = true;
        break;
      }

      if (extension && extensionInList(extension, element.options.acceptFile[i])) { // extension could be list of format; e.g. for the svg it is svg+xml
        accepted = true;
        break;
      }
    }
    return accepted;
  };

  function extensionInList(extensionList, extension) {
    // extension could be .svg, .pdf, ..
    // extensionList could be png, svg+xml, ...
    if ('.' + extensionList == extension) return true;
    var accepted = false;
    var extensionListArray = extensionList.split('+');
    for (var i = 0; i < extensionListArray.length; i++) {
      if ('.' + extensionListArray[i] == extension) {
        accepted = true;
        break;
      }
    }
    return accepted;
  }

  function filterMaxFiles(element) { // check number of uploaded files
    if (element.options.maxFiles >= element.droppedFiles.length) return;
    var rejected = [];
    while (element.droppedFiles.length > element.options.maxFiles) {
      var rejectedFile = element.droppedFiles.pop();
      element.lastDroppedFiles.pop();
      rejected.push(rejectedFile.name);
    }

    if (rejected.length > 0) {
      emitCustomEvents(element, 'rejectedNumber', rejected);
    }
  };

  function updateDndAreaMessage(element) {
    if (element.progress && element.progress[0]) { // reset progress bar 
      element.progressObj[0].setProgressBarValue(0);
      Util.toggleClass(element.progress[0], 'is-hidden', element.droppedFiles.length == 0);
      Util.removeClass(element.progress[0], element.progressCompleteClass);
    }

    if (element.droppedFiles.length > 0 && element.labelEndMessage) {
      var finalMessage = element.labelEnd.innerHTML;
      if (element.labelEndMessage.length > 3) {
        finalMessage = element.droppedFiles.length > 1
          ? element.labelEndMessage[0] + element.labelEndMessage[2] + element.labelEndMessage[3]
          : element.labelEndMessage[0] + element.labelEndMessage[1] + element.labelEndMessage[3];
      }
      element.labelEnd[0].innerHTML = finalMessage.replace('{n}', element.droppedFiles.length);
    }
  };

  function updateDndList(element) {
    // create new list of files to be appended
    if (!element.fileItems || element.fileItems.length == 0) return
    var clone = element.fileItems[0].cloneNode(true),
      string = '';
    Util.removeClass(clone, 'is-hidden');
    for (var i = 0; i < element.lastDroppedFiles.length; i++) {
      clone.getElementsByClassName('js-ddf__file-name')[0].textContent = element.lastDroppedFiles[i].name;
      string = clone.outerHTML + string;
    }

    if (element.options.replaceFiles) { // replace all files in list with new files
      string = element.fileItems[0].outerHTML + string;
      element.filesList[0].innerHTML = string;
    } else {
      element.fileItems[0].insertAdjacentHTML('afterend', string);
    }

    if (element.options.upload) storeMultipleProgress(element);

    Util.toggleClass(element.filesList[0], 'is-hidden', element.droppedFiles.length == 0);
  };

  function initRemoveFile(element) { // if list of files is visible - option to remove file from list
    element.filesList[0].addEventListener('click', function (event) {
      if (!event.target.closest('.js-ddf__remove-btn')) return;
      event.preventDefault();
      var item = event.target.closest('.js-ddf__item'),
        index = Util.getIndexInArray(element.filesList[0].getElementsByClassName('js-ddf__item'), item);

      var removedFile = element.droppedFiles.splice(element.droppedFiles.length - index, 1);
      if (element.progress && element.progress.length > element.droppedFiles.length - index) {
        element.progress.splice();
      }
      // check if we need to remove items form the lastDroppedFiles array
      var lastDroppedIndex = element.lastDroppedFiles.length - index;
      if (lastDroppedIndex >= 0 && lastDroppedIndex < element.lastDroppedFiles.length - 1) {
        element.lastDroppedFiles.splice(element.lastDroppedFiles.length - index, 1);
      }
      item.remove();
      emitCustomEvents(element, 'fileRemoved', removedFile);
    });

  };

  function storeMultipleProgress(element) { // handle progress bar elements
    element.progress = [];
    var delta = element.droppedFiles.length - element.lastDroppedFiles.length;
    for (var i = 0; i < element.lastDroppedFiles.length; i++) {
      element.progress[i] = element.fileItems[element.droppedFiles.length - delta - i].getElementsByClassName('js-ddf__progress')[0];
    }
    initProgress(element, 0, element.lastDroppedFiles.length, true);
  };

  function initProgress(element, start, end, bool) {
    element.progressObj = [];
    if (!element.progress || element.progress.length == 0) return;
    for (var i = start; i < end; i++) {
      (function (i) {
        element.progressObj.push(new CProgressBar(element.progress[i]));
        if (bool) Util.removeClass(element.progress[i], 'is-hidden');
        // listen for 100% progress
        element.progress[i].addEventListener('updateProgress', function (event) {
          if (event.detail.value == 100) Util.addClass(element.progress[i], element.progressCompleteClass);
        });
      })(i);
    }
  };

  function emitCustomEvents(element, eventName, detail) {
    var event = new CustomEvent(eventName, { detail: detail });
    element.element.dispatchEvent(event);
  };

  Ddf.defaults = {
    element: '',
    maxFiles: false, // max number of files
    maxSize: false, // max weight - set in kb
    showFiles: false, // show list of selected files
    replaceFiles: true, // when new files are loaded -> they replace the old ones
    upload: false // show progress bar for the upload process
  };

  window.Ddf = Ddf;
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
// File#: _2_grid-switch
// Usage: codyhouse.co/license
(function() {
    var GridSwitch = function(element) {
      this.element = element;
      this.controller = this.element.getElementsByClassName('js-grid-switch__controller')[0];
      this.items = this.element.getElementsByClassName('js-grid-switch__item');
      this.contentElements = this.element.getElementsByClassName('js-grid-switch__content');
      // store custom classes
      this.classList = [[this.element.getAttribute('data-gs-item-class-1'), this.element.getAttribute('data-gs-content-class-1')], [this.element.getAttribute('data-gs-item-class-2'), this.element.getAttribute('data-gs-content-class-2')]];
      initGridSwitch(this);
    };
  
    function initGridSwitch(element) {
      // get selected state and apply style
      var selectedInput = element.controller.querySelector('input:checked');
      if(selectedInput) {
        setGridAppearance(element, selectedInput.value);
      }
      // reveal grid
      Util.addClass(element.element, 'grid-switch--is-visible');
      // a new layout has been selected 
      element.controller.addEventListener('change', function(event) {
        setGridAppearance(element, event.target.value);
      });
    };
  
    function setGridAppearance(element, value) {
      var newStatus = parseInt(value) - 1,
        oldStatus = newStatus == 1 ? 0 : 1;
        
      for(var i = 0; i < element.items.length; i++) {
        Util.removeClass(element.items[i], element.classList[oldStatus][0]);
        Util.removeClass(element.contentElements[i], element.classList[oldStatus][1]);
        Util.addClass(element.items[i], element.classList[newStatus][0]);
        Util.addClass(element.contentElements[i], element.classList[newStatus][1]);
      }
    };
  
    //initialize the GridSwitch objects
    var gridSwitch = document.getElementsByClassName('js-grid-switch');
    if( gridSwitch.length > 0 ) {
      for( var i = 0; i < gridSwitch.length; i++) {
        (function(i){new GridSwitch(gridSwitch[i]);})(i);
      }
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
// File#: _2_multiple-custom-select
// Usage: codyhouse.co/license
(function () {
	var MultiCustomSelect = function (element) {
		this.element = element;
		this.select = this.element.getElementsByTagName('select')[0];
		this.optGroups = this.select.getElementsByTagName('optgroup');
		this.options = this.select.getElementsByTagName('option');
		this.selectId = this.select.getAttribute('id');
		this.trigger = false;
		this.dropdown = false;
		this.customOptions = false;
		this.arrowIcon = this.element.getElementsByTagName('svg');
		this.label = document.querySelector('[for="' + this.selectId + '"]');
		this.selectedOptCounter = 0;

		this.optionIndex = 0; // used while building the custom dropdown

		// label options
		this.noSelectText = this.element.getAttribute('data-no-select-text') || 'Select';
		this.multiSelectText = this.element.getAttribute('data-multi-select-text') || '{n} items selected';
		this.nMultiSelect = this.element.getAttribute('data-n-multi-select') || 2;
		this.noUpdateLabel = this.element.getAttribute('data-update-text') && this.element.getAttribute('data-update-text') == 'off';
		this.insetLabel = this.element.getAttribute('data-inset-label') && this.element.getAttribute('data-inset-label') == 'on';

		// init
		initCustomSelect(this); // init markup
		initCustomSelectEvents(this); // init event listeners
	};

	function initCustomSelect(select) {
		// create the HTML for the custom dropdown element
		select.element.insertAdjacentHTML('beforeend', initButtonSelect(select) + initListSelect(select));

		// save custom elements
		select.dropdown = select.element.getElementsByClassName('js-multi-select__dropdown')[0];
		select.trigger = select.element.getElementsByClassName('js-multi-select__button')[0];
		select.customOptions = select.dropdown.getElementsByClassName('js-multi-select__option');

		// hide default select
		Util.addClass(select.select, 'is-hidden');
		if (select.arrowIcon.length > 0) select.arrowIcon[0].style.display = 'none';
	};

	function initCustomSelectEvents(select) {
		// option selection in dropdown
		initSelection(select);

		// click events
		select.trigger.addEventListener('click', function (event) {
			event.preventDefault();
			toggleCustomSelect(select, false);
		});
		if (select.label) {
			// move focus to custom trigger when clicking on <select> label
			select.label.addEventListener('click', function () {
				Util.moveFocus(select.trigger);
			});
		}
		// keyboard navigation
		select.dropdown.addEventListener('keydown', function (event) {
			if (event.keyCode && event.keyCode == 38 || event.key && event.key.toLowerCase() == 'arrowup') {
				keyboardCustomSelect(select, 'prev', event);
			} else if (event.keyCode && event.keyCode == 40 || event.key && event.key.toLowerCase() == 'arrowdown') {
				keyboardCustomSelect(select, 'next', event);
			}
		});
	};

	function toggleCustomSelect(select, bool) {
		var ariaExpanded;
		if (bool) {
			ariaExpanded = bool;
		} else {
			ariaExpanded = select.trigger.getAttribute('aria-expanded') == 'true' ? 'false' : 'true';
		}
		select.trigger.setAttribute('aria-expanded', ariaExpanded);
		if (ariaExpanded == 'true') {
			var selectedOption = getSelectedOption(select);
			Util.moveFocus(selectedOption); // fallback if transition is not supported
			select.dropdown.addEventListener('transitionend', function cb() {
				Util.moveFocus(selectedOption);
				select.dropdown.removeEventListener('transitionend', cb);
			});
			placeDropdown(select); // place dropdown based on available space
		}
	};

	function placeDropdown(select) {
		var triggerBoundingRect = select.trigger.getBoundingClientRect();
		Util.toggleClass(select.dropdown, 'multi-select__dropdown--right', (window.innerWidth < triggerBoundingRect.left + select.dropdown.offsetWidth));
		// check if there's enough space up or down
		var moveUp = (window.innerHeight - triggerBoundingRect.bottom) < triggerBoundingRect.top;
		Util.toggleClass(select.dropdown, 'multi-select__dropdown--up', moveUp);
		// check if we need to set a max height
		var maxHeight = moveUp ? triggerBoundingRect.top - 20 : window.innerHeight - triggerBoundingRect.bottom - 20;
		// set max-height (based on available space) and width
		select.dropdown.setAttribute('style', 'max-height: ' + maxHeight + 'px; width: ' + triggerBoundingRect.width + 'px;');
	};

	function keyboardCustomSelect(select, direction, event) { // navigate custom dropdown with keyboard
		event.preventDefault();
		var index = Util.getIndexInArray(select.customOptions, document.activeElement.closest('.js-multi-select__option'));
		index = (direction == 'next') ? index + 1 : index - 1;
		if (index < 0) index = select.customOptions.length - 1;
		if (index >= select.customOptions.length) index = 0;
		Util.moveFocus(select.customOptions[index].getElementsByClassName('js-multi-select__checkbox')[0]);
	};

	function initSelection(select) { // option selection
		select.dropdown.addEventListener('change', function (event) {
			var option = event.target.closest('.js-multi-select__option');
			if (!option) return;
			selectOption(select, option);
		});
		select.dropdown.addEventListener('click', function (event) {
			var option = event.target.closest('.js-multi-select__option');
			if (!option || !Util.hasClass(event.target, 'js-multi-select__option')) return;
			selectOption(select, option);
		});
	};

	function selectOption(select, option) {
		if (option.hasAttribute('aria-selected') && option.getAttribute('aria-selected') == 'true') {
			// deselecting that option
			option.setAttribute('aria-selected', 'false');
			// update native select element
			updateNativeSelect(select, option.getAttribute('data-index'), false);
		} else {
			option.setAttribute('aria-selected', 'true');
			// update native select element
			updateNativeSelect(select, option.getAttribute('data-index'), true);

		}
		var triggerLabel = getSelectedOptionText(select);
		select.trigger.getElementsByClassName('js-multi-select__label')[0].innerHTML = triggerLabel[0]; // update trigger label
		Util.toggleClass(select.trigger, 'multi-select__button--active', select.selectedOptCounter > 0);
		updateTriggerAria(select, triggerLabel[1]); // update trigger arai-label
	};

	function updateNativeSelect(select, index, bool) {
		select.options[index].selected = bool;
		select.select.dispatchEvent(new CustomEvent('change', { bubbles: true })); // trigger change event
	};

	function updateTriggerAria(select, ariaLabel) { // new label for custom triegger
		select.trigger.setAttribute('aria-label', ariaLabel);
	};

	function getSelectedOptionText(select) {// used to initialize the label of the custom select button
		var noSelectionText = '<span class="multi-select__term">' + select.noSelectText + '</span>';
		if (select.noUpdateLabel) return [noSelectionText, select.noSelectText];
		var label = '';
		var ariaLabel = '';
		select.selectedOptCounter = 0;

		for (var i = 0; i < select.options.length; i++) {
			if (select.options[i].selected) {
				if (select.selectedOptCounter != 0) label = label + ', '
				label = label + '' + select.options[i].text;
				select.selectedOptCounter = select.selectedOptCounter + 1;
			}
		}

		if (select.selectedOptCounter > select.nMultiSelect) {
			label = '<span class="multi-select__details">' + select.multiSelectText.replace('{n}', select.selectedOptCounter) + '</span>';
			ariaLabel = select.multiSelectText.replace('{n}', select.selectedOptCounter) + ', ' + select.noSelectText;
		} else if (select.selectedOptCounter > 0) {
			ariaLabel = label + ', ' + select.noSelectText;
			label = '<span class="multi-select__details">' + label + '</span>';
		} else {
			label = noSelectionText;
			ariaLabel = select.noSelectText;
		}

		if (select.insetLabel && select.selectedOptCounter > 0) label = noSelectionText + label;
		return [label, ariaLabel];
	};

	function initButtonSelect(select) { // create the button element -> custom select trigger
		// check if we need to add custom classes to the button trigger
		var customClasses = select.element.getAttribute('data-trigger-class') ? ' ' + select.element.getAttribute('data-trigger-class') : '';

		var triggerLabel = getSelectedOptionText(select);
		var activeSelectionClass = select.selectedOptCounter > 0 ? ' multi-select__button--active' : '';

		var button = '<button class="js-multi-select__button multi-select__button' + customClasses + activeSelectionClass + '" aria-label="' + triggerLabel[1] + '" aria-expanded="false" aria-controls="' + select.selectId + '-dropdown"><span aria-hidden="true" class="js-multi-select__label multi-select__label">' + triggerLabel[0] + '</span>';
		if (select.arrowIcon.length > 0 && select.arrowIcon[0].outerHTML) {
			button = button + select.arrowIcon[0].outerHTML;
		}

		return button + '</button>';

	};

	function initListSelect(select) { // create custom select dropdown
		var list = '<div class="js-multi-select__dropdown multi-select__dropdown" aria-describedby="' + select.selectId + '-description" id="' + select.selectId + '-dropdown">';
		list = list + getSelectLabelSR(select);
		if (select.optGroups.length > 0) {
			for (var i = 0; i < select.optGroups.length; i++) {
				var optGroupList = select.optGroups[i].getElementsByTagName('option'),
					optGroupLabel = '<li><span class="multi-select__item multi-select__item--optgroup">' + select.optGroups[i].getAttribute('label') + '</span></li>';
				list = list + '<ul class="multi-select__list" role="listbox" aria-multiselectable="true">' + optGroupLabel + getOptionsList(select, optGroupList) + '</ul>';
			}
		} else {
			list = list + '<ul class="multi-select__list" role="listbox" aria-multiselectable="true">' + getOptionsList(select, select.options) + '</ul>';
		}
		return list;
	};

	function getSelectLabelSR(select) {
		if (select.label) {
			return '<p class="sr-only" id="' + select.selectId + '-description">' + select.label.textContent + '</p>'
		} else {
			return '';
		}
	};

	function getOptionsList(select, options) {
		var list = '';
		for (var i = 0; i < options.length; i++) {
			var selected = options[i].hasAttribute('selected') ? ' aria-selected="true"' : ' aria-selected="false"',
				checked = options[i].hasAttribute('selected') ? 'checked' : '';
			list = list + '<li class="js-multi-select__option" role="option" data-value="' + options[i].value + '" ' + selected + ' data-label="' + options[i].text + '" data-index="' + select.optionIndex + '"><input aria-hidden="true" class="checkbox js-multi-select__checkbox" type="checkbox" id="' + select.selectId + '-' + options[i].value + '-' + select.optionIndex + '" ' + checked + '><label class="multi-select__item multi-select__item--option" aria-hidden="true" for="' + select.selectId + '-' + options[i].value + '-' + select.optionIndex + '"><span>' + options[i].text + '</span></label></li>';
			select.optionIndex = select.optionIndex + 1;
		};
		return list;
	};

	function getSelectedOption(select) { // return first selected option
		var option = select.dropdown.querySelector('[aria-selected="true"]');
		if (option) return option.getElementsByClassName('js-multi-select__checkbox')[0];
		else return select.dropdown.getElementsByClassName('js-multi-select__option')[0].getElementsByClassName('js-multi-select__checkbox')[0];
	};

	function moveFocusToSelectTrigger(select) {
		if (!document.activeElement.closest('.js-multi-select')) return
		select.trigger.focus();
	};

	function checkCustomSelectClick(select, target) { // close select when clicking outside it
		if (!select.element.contains(target)) toggleCustomSelect(select, 'false');
	};

	//initialize the CustomSelect objects
	var customSelect = document.getElementsByClassName('js-multi-select');
	if (customSelect.length > 0) {
		var selectArray = [];
		for (var i = 0; i < customSelect.length; i++) {
			(function (i) { selectArray.push(new MultiCustomSelect(customSelect[i])); })(i);
		}

		// listen for key events
		window.addEventListener('keyup', function (event) {
			if (event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape') {
				// close custom select on 'Esc'
				selectArray.forEach(function (element) {
					moveFocusToSelectTrigger(element); // if focus is within dropdown, move it to dropdown trigger
					toggleCustomSelect(element, 'false'); // close dropdown
				});
			}
		});
		// close custom select when clicking outside it
		window.addEventListener('click', function (event) {
			selectArray.forEach(function (element) {
				checkCustomSelectClick(element, event.target);
			});
		});
	}
}());
// File#: _2_slider-multi-value
// Usage: codyhouse.co/license
(function() {
	var SliderMulti = function(element) {
		this.element = element;
		this.rangeWrapper = this.element.getElementsByClassName('slider__range');
		this.rangeInput = this.element.getElementsByClassName('slider__input');
		this.rangeMin = this.rangeInput[0].getAttribute('min');
		this.rangeMax = this.rangeInput[0].getAttribute('max');
		this.sliderWidth = window.getComputedStyle(this.element.getElementsByClassName('slider__range')[0]).getPropertyValue('width');
		this.thumbWidth = getComputedStyle(this.element).getPropertyValue('--slide-thumb-size');
		initSliderMulti(this);
	};

	function initSliderMulti(slider) {
		// toggle custom class based on browser support
		toggleMsClass(slider);

		// init bg color of the slider
		updateRangeColor(slider);

		slider.element.addEventListener('updateRange', function(event){
			checkRangeValues(slider, event.detail);
			updateRangeColor(slider);
		});

		// custom event emitted after window resize
		slider.element.addEventListener('update-slider-multi-value', function(event){
			slider.sliderWidth = window.getComputedStyle(slider.element.getElementsByClassName('slider__range')[0]).getPropertyValue('width');
			updateRangeColor(slider);
		});
	};

	function checkRangeValues(slider, index) {
		// if min value was changed -> make sure min value is smaller than max value 
		// if max value was changed -> make sure max value is bigger than min value 
		var i = (index == 0) ? 1 : 0,
			limit = parseFloat(slider.rangeInput[i].value);
		if( (index == 0 && slider.rangeInput[0].value >= limit) || (index == 1 && slider.rangeInput[1].value <= limit) ) {
			slider.rangeInput[index].value = limit;
			slider.element.dispatchEvent(new CustomEvent('inputRangeLimit', {detail: index}))
		}
	};

	function updateRangeColor(slider) { // update background fill color of the slider
		var percentageStart = parseInt((slider.rangeInput[0].value - slider.rangeMin)/(slider.rangeMax - slider.rangeMin)*100),
			percentageEnd = parseInt((slider.rangeInput[1].value - slider.rangeMin)/(slider.rangeMax - slider.rangeMin)*100), 
			start = 'calc('+percentageStart+'*('+slider.sliderWidth+' - 0.5*'+slider.thumbWidth+')/100)',
			end = 'calc('+percentageEnd+'*('+slider.sliderWidth+' - 0.5*'+slider.thumbWidth+')/100)';

		slider.rangeWrapper[0].style.setProperty('--slider-fill-value-start', start);
		slider.rangeWrapper[0].style.setProperty('--slider-fill-value-end', end);
	};

	function toggleMsClass(slider) {
		var cssVariablesSupport = Util.cssSupports('--color-value', 'red'),
			imeAlignSuport = Util.cssSupports('-ms-ime-align', 'auto');
		if(imeAlignSuport || !cssVariablesSupport) Util.addClass(slider.element, 'slider--ms-fallback'); // IE and Edge (<=18) Fallback
	};

	//initialize the SliderMulti objects
	var slidersMulti = document.getElementsByClassName('js-slider');
	if( slidersMulti.length > 0 ) {
		var slidersMultiArray = [];
		for( var i = 0; i < slidersMulti.length; i++) {(function(i){
			if(slidersMulti[i].getElementsByClassName('slider__input').length > 1) slidersMultiArray.push(new SliderMulti(slidersMulti[i]));
		})(i);}
		if(slidersMultiArray.length > 0) {
			var resizingId = false,
        customEvent = new CustomEvent('update-slider-multi-value');
      
      window.addEventListener('resize', function() {
        clearTimeout(resizingId);
        resizingId = setTimeout(doneResizing, 500);
      });

      function doneResizing() {
        for( var i = 0; i < slidersMultiArray.length; i++) {
          (function(i){slidersMultiArray[i].element.dispatchEvent(customEvent)})(i);
        };
      };
		}
	}
}());
// File#: _2_slideshow
// Usage: codyhouse.co/license
(function() {
	var Slideshow = function(opts) {
		this.options = slideshowAssignOptions(Slideshow.defaults , opts);
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

	function slideshowAssignOptions(defaults, opts) {
		// initialize the object options
		var mergeOpts = {};
		mergeOpts.element = (typeof opts.element !== "undefined") ? opts.element : defaults.element;
		mergeOpts.navigation = (typeof opts.navigation !== "undefined") ? opts.navigation : defaults.navigation;
		mergeOpts.autoplay = (typeof opts.autoplay !== "undefined") ? opts.autoplay : defaults.autoplay;
		mergeOpts.autoplayInterval = (typeof opts.autoplayInterval !== "undefined") ? opts.autoplayInterval : defaults.autoplayInterval;
		mergeOpts.swipe = (typeof opts.swipe !== "undefined") ? opts.swipe : defaults.swipe;
		return mergeOpts;
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
			slideshow.element.addEventListener('mouseenter', function(event){
				slideshow.pauseAutoplay();
				slideshow.autoplayPaused = true;
			});
			slideshow.element.addEventListener('focusin', function(event){
				slideshow.pauseAutoplay();
				slideshow.autoplayPaused = true;
			});
			slideshow.element.addEventListener('mouseleave', function(event){
				slideshow.autoplayPaused = false;
				slideshow.startAutoplay();
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
					autoplayInterval = (slideshows[i].getAttribute('data-autoplay-interval')) ? slideshows[i].getAttribute('data-autoplay-interval') : 5000,
					swipe = (slideshows[i].getAttribute('data-swipe') && slideshows[i].getAttribute('data-swipe') == 'on') ? true : false;
				new Slideshow({element: slideshows[i], navigation: navigation, autoplay : autoplay, autoplayInterval : autoplayInterval, swipe : swipe});
			})(i);
		}
	}
}());
// File#: _3_dashboard-navigation
// Usage: codyhouse.co/license
(function() {
  var appUi = document.getElementsByClassName('js-app-ui');
  if(appUi.length > 0) {
    var appMenuBtn = appUi[0].getElementsByClassName('js-app-ui__menu-btn');
    if(appMenuBtn.length < 1) return;
    var appExpandedClass = 'app-ui--nav-expanded';
    var firstFocusableElement = false,
      // we'll use these to store the node that needs to receive focus when the mobile menu is closed 
      focusMenu = false;

    // toggle navigation on mobile
    appMenuBtn[0].addEventListener('click', function(event) {
      var openMenu = !Util.hasClass(appUi[0], appExpandedClass);
      Util.toggleClass(appUi[0], appExpandedClass, openMenu);
      appMenuBtn[0].setAttribute('aria-expanded', openMenu);
			if(openMenu) {
        firstFocusableElement = getMenuFirstFocusable();
        if(firstFocusableElement) firstFocusableElement.focus(); // move focus to first focusable element
      } else if(focusMenu) {
				focusMenu.focus();
				focusMenu = false;
			}
    });

    // listen for key events
		window.addEventListener('keyup', function(event){
			// listen for esc key
			if( (event.keyCode && event.keyCode == 27) || (event.key && event.key.toLowerCase() == 'escape' )) {
				// close navigation on mobile if open
				if(appMenuBtn[0].getAttribute('aria-expanded') == 'true' && isVisible(appMenuBtn[0])) {
					focusMenu = appMenuBtn[0]; // move focus to menu trigger when menu is close
					appMenuBtn[0].click();
				}
			}
			// listen for tab key
			if( (event.keyCode && event.keyCode == 9) || (event.key && event.key.toLowerCase() == 'tab' )) {
				// close navigation on mobile if open when nav loses focus
				if(appMenuBtn[0].getAttribute('aria-expanded') == 'true' && isVisible(appMenuBtn[0]) && !document.activeElement.closest('.js-app-ui__nav')) appMenuBtn[0].click();
			}
    });
    
    // listen for resize
		var resizingId = false;
		window.addEventListener('resize', function() {
			clearTimeout(resizingId);
			resizingId = setTimeout(doneResizing, 500);
		});

		function doneResizing() {
			if( !isVisible(appMenuBtn[0]) && Util.hasClass(appUi[0], appExpandedClass)) appMenuBtn[0].click();
		};

    function getMenuFirstFocusable() {
      var mobileNav = appUi[0].getElementsByClassName('js-app-ui__nav');
      if(mobileNav.length < 1) return false;
			var focusableEle = mobileNav[0].querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"]), [controls], summary'),
        firstFocusable = false;
			for(var i = 0; i < focusableEle.length; i++) {
				if( focusableEle[i].offsetWidth || focusableEle[i].offsetHeight || focusableEle[i].getClientRects().length ) {
					firstFocusable = focusableEle[i];
					break;
				}
      }
      
			return firstFocusable;
    };
    
    function isVisible(element) {
      return (element.offsetWidth || element.offsetHeight || element.getClientRects().length);
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
// File#: _3_explorer
// Usage: codyhouse.co/license
(function () {
  /// 👇you should remove this from your live code



  /// 👆end of demo code


  function explorerSearch(query, cb) {
    // get search results
    // more info: https://codyhouse.co/ds/components/info/autocomplete#search-data

    // quick links - visible when the input is empty
    if (query == '') {
      cb(explorerQuickLinks); // pass your real list of quick links
      return;
    }

    // 👇 get results - you should modify this with your real data
    var quickLinks = explorerQuickLinks.filter(function (item) {
      // return item if item['label'] contains 'query'
      return item['label'].toLowerCase().indexOf(query.toLowerCase()) > -1;
    });
    var data = explorerAdditionalLinks.filter(function (item) {
      // return item if item['label'] contains 'query'
      return item['label'].toLowerCase().indexOf(query.toLowerCase()) > -1;
    });
    data = quickLinks.concat(data);
    // 👆 get results - you should modify this with your real data

    if (data.length == 0) { // fallback for no results found
      // no results found
      data = [{
        label: 'No results',
        template: 'no-results'
      }];
    }

    // make sure to call the callback function and pass the data array as its argument
    cb(data);
  };

  function explorerClick(option, obj, event) {
    // custom function to be execute when user selects an option
    // more info: https://codyhouse.co/ds/components/info/autocomplete#on-click
    click();
    event.preventDefault();
  };

  var explorer = document.getElementsByClassName('js-explorer');
  if (explorer.length > 0) {
    var modalExplorer = explorer[0].closest('.js-modal');
    var explorerInput = explorer[0].getElementsByClassName('js-autocomplete__input');
    new Autocomplete({
      element: explorer[0],
      characters: 0,
      searchData: function (value, cb) { // function that gets result data
        explorerSearch(value, cb);
      },
      onClick: function (option, obj, event) { // function to be executed on click
        explorerClick(option, obj, event);
      }
    });

    if (modalExplorer) {
      modalExplorer.addEventListener('modalIsClose', function (event) {
        // reset search input when closing the modal window
        if (explorerInput.length > 0) {
          explorerInput[0].value = '';
        }
      });
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
        var triggerBtn = event.target.closest('.js-mega-nav__control');
        if(!triggerBtn) return;
        var mainItem = triggerBtn.closest('.js-mega-nav__item');
        if(!mainItem) return;
        var itemExpanded = Util.hasClass(mainItem, megaNav.itemExpClass);
        Util.toggleClass(mainItem, megaNav.itemExpClass, !itemExpanded);
        itemExpanded ? triggerBtn.removeAttribute('aria-expanded') : triggerBtn.setAttribute('aria-expanded', 'true');
        if(megaNav.layout == 'desktop' && !itemExpanded) closeSubNav(megaNav, mainItem);
        // close search if open
        closeSearch(megaNav, false);
        resetNavAppearance(megaNav); // reset nav expanded appearance
      });
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

  // init the SelectAuto object
  var selectAuto = document.getElementsByClassName('js-select-auto');
  if( selectAuto.length > 0 ) {
    for( var i = 0; i < selectAuto.length; i++) {
      (function(i){new SelectAuto(selectAuto[i]);})(i);
    }
  }
}());