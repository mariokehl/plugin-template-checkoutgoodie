/**
 * Main function to handle goodie goal
 */
function CheckoutGoodie() {
    this.itemSum = 0.0;
    this.sync = function () {
        let self = this;
        $.ajax({
            url: '/plugin/checkout-goodie/basket-value/',
            method: 'GET',
            success: function (res) {
              console.log(res);
              self.itemSum = res.basketValue;
            }
        });
    },
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
    this.calc = function () {
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
        const progress = document.querySelectorAll('[role="progressbar"]')[0];
        progress.setAttribute('aria-valuenow', pr);
        progress.style['width'] = pr + '%';

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
                el.innerHTML = self.calc();
            });
        }
    },
    this.sync();
}

// Initial setup in checkout view
window.addEventListener('load', () => { new CheckoutGoodie().setLabel(); }, false);

// Shopping cart preview is opened for the first time
waitForElement('.basket-preview').then(() => { new CheckoutGoodie().setLabel(); });

// A new item has been added to the shopping cart
document.addEventListener('afterBasketItemAdded', () => { new CheckoutGoodie().setLabel(); }, false);

// When the shopping cart is updated (gets only triggered for existing basket)
document.addEventListener('afterBasketChanged', () => { new CheckoutGoodie().setLabel(); }, false);


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