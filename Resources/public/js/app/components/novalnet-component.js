define(function (require) {
    'use strict';

    let NovalnetComponent;
    const _ = require('underscore');
    const mediator = require('oroui/js/mediator');
    const BaseComponent = require('oroui/js/app/components/base/component');

    NovalnetComponent = BaseComponent.extend({
        /**
         * @property {Object}
         */
        options: {
            paymentMethod: null
        },

        /**
         * @inheritDoc
         */
        constructor: function NovalnetComponent()
        {
            NovalnetComponent.__super__.constructor.apply(this, arguments);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);

            mediator.on('checkout:place-order:response', this.handleSubmit, this);
        },

        /**
         * @param {Object} eventData
         */
        handleSubmit: function (eventData) {

            if (eventData.responseData.paymentMethod === this.options.paymentMethod) {
                eventData.stopped = true;
                if (!eventData.responseData.purchaseRedirectUrl) {
					mediator.execute('redirectTo', {url: eventData.responseData.errorUrl}, {redirect: true});
                    return;
                }
                window.location = eventData.responseData.purchaseRedirectUrl;
            }
        },

        dispose: function () {
            if (this.disposed) {
                return;
            }

            mediator.off('checkout:place-order:response', this.handleSubmit, this);

            NovalnetComponent.__super__.dispose.call(this);
        }
    });

    return NovalnetComponent;
});
