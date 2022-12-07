/**
 * Main function to handle goodie goal
 * 
 * @param {number|null} itemSum 
 */
function CheckoutGoodie(itemSum) {
    this.itemSum = itemSum;
    this.getConfig = function () {
        const json = JSON.parse(document.getElementById('checkout-goodie-config').textContent);
        return json;
    },
    this.getGrossValue = function () {
        const config = this.getConfig();
        return config.grossValue;
    },
    this.getItemSum = function () {
        if (typeof this.itemSum === 'number') return this.itemSum;
        const config = this.getConfig();
        return config.initialData.amount;
    },
    this.getGoalReachedMessage = function () {
        const config = this.getConfig();
        return config.messages.goal;
    },
    this.getNextGoal = function () {
        const config = this.getConfig();
        if (config.thresholds.length === 0) return this.getGrossValue();
        if (config.thresholds[0] && this.getItemSum() < config.thresholds[0]) return config.thresholds[0];
        if (config.thresholds[1] && this.getItemSum() < config.thresholds[1]) return config.thresholds[1];
        return this.getGrossValue();
    },
    this.getMissingMessage = function (amount, interim) {
        const config = this.getConfig();
        let msg = interim ? config.messages.interim : config.messages.missing;
        msg = msg.replace(':amount', Intl.NumberFormat('de-DE', { maximumFractionDigits: 2, minimumFractionDigits: 2 }).format(amount));
        msg = msg.replace(':currency', config.currency);
        return msg;
    },
    this.getPercentage = function () {
        let pr = (this.getItemSum() / this.getGrossValue()) * 100;
        pr = Math.floor(pr);
        pr = (pr > 100) ? 100 : pr;
        return pr;
    },
    this.calc = function (el) {
        let output;

        const amount = (this.getNextGoal() - this.getItemSum());
        if (amount <= 0) {
            output = this.getGoalReachedMessage();
        } else {
            if (this.getNextGoal() !== this.getGrossValue()) {
                output = this.getMissingMessage(amount, true);
            } else {
                output = this.getMissingMessage(amount);
            }
        }
        const pr = this.getPercentage();
        const pb = document.querySelectorAll('[role="progressbar"]')[0];
        pb.setAttribute('aria-valuenow', pr);
        pb.style['width'] = pr + '%';

        // Toggle classes
        const config = this.getConfig();
        if (amount <= 0) {
            el.classList.remove(config.classes.missingAmount);
            el.classList.add(config.classes.reachedAmount);
            pb.classList.remove(config.classes.missingAmount);
            pb.classList.add(config.classes.reachedAmount);
        } else {
            el.classList.remove(config.classes.reachedAmount);
            el.classList.add(config.classes.missingAmount);
            pb.classList.remove(config.classes.reachedAmount);
            pb.classList.add(config.classes.missingAmount);
        }

        return output;
    },
    this.init = function () {
        let config = this.getConfig();
        if (this.itemSum) {
            config.initialData.amount = this.itemSum;
            config.initialData.percentage = this.getPercentage();
            document.getElementById('checkout-goodie-config').textContent = JSON.stringify(config);
        }
    },
    this.setLabel = function () {
        const els = document.getElementsByClassName('missing-goodie-amount');
        if (!els.length) {
            this.init();
            return;
        } else {
            const self = this;
            Array.prototype.forEach.call(els, function (el) {
                el.style.display = 'none';
                el.innerHTML = self.calc(el);
                el.style.display = 'block';
            });
        }
    }
}

// Initial setup in checkout view
window.addEventListener('load', () => {
    const goodie = new CheckoutGoodie(null);
    goodie.setLabel();
}, false);

// Shopping cart preview is opened for the first time
waitForElement('.basket-preview').then(() => {
    const goodie = new CheckoutGoodie(null);
    goodie.setLabel();
});

// A new item has been added to the shopping cart
document.addEventListener('afterBasketItemAdded', (e) => {
    const textualAmount = document.querySelector('.toggle-basket-preview .badge').textContent; // e.g. 44,99 EUR
    const itemSum = toFloat(textualAmount);
    const goodie = new CheckoutGoodie(itemSum);
    goodie.setLabel();
}, false);

// When the shopping cart is updated (gets only triggered for existing basket)
document.addEventListener('afterBasketChanged', (e) => {
    const basket = e.detail;
    const itemSum = basket.itemSum + (basket.couponCampaignType === 'promotion' ? basket.couponDiscount : 0);
    const goodie = new CheckoutGoodie(itemSum);
    goodie.setLabel();
}, false);


/**
 * Helper function to wait until an element exists
 * 
 * @param {string} selector 
 */
function waitForElement(selector) {
  return new Promise((resolve) => {
    if (document.querySelector(selector)) {
      return resolve(document.querySelector(selector));
    }

    const observer = new MutationObserver((mutations) => {
      if (document.querySelector(selector)) {
        resolve(document.querySelector(selector));
        observer.disconnect();
      }
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  });
}

/**
 * Convert a currency string to a double
 * 
 * @param {string} num
 * @returns {number}
 */
function toFloat(num) {
  let dotPos = num.indexOf('.');
  if (dotPos < 0) dotPos = 0;

  let commaPos = num.indexOf(',');
  if (commaPos < 0) commaPos = 0;

  let sep;
  if (dotPos > commaPos && dotPos) sep = dotPos;
  else {
    if (commaPos > dotPos && commaPos) sep = commaPos;
    else sep = false;
  }

  if (sep == false) return parseFloat(num.replace(/[^\d]/g, ''));

  return parseFloat(num.substr(0, sep).replace(/[^\d]/g, '') + '.' + num.substr(sep + 1, num.length).replace(/[^0-9]/, ''));
}