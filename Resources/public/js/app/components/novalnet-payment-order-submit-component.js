import _ from 'underscore';
import mediator from 'oroui/js/mediator';
import BaseComponent from 'oroui/js/app/components/base/component';

const NovalnetComponent = BaseComponent.extend({
    options: {
        paymentMethod: null
    },

    constructor: function NovalnetComponent() {
        NovalnetComponent.__super__.constructor.apply(this, arguments);
    },

    initialize: function(options) {
        this.options = _.extend({}, this.options, options);
        mediator.on('checkout:place-order:response', this.handleSubmit, this);
    },

    handleSubmit: function(eventData) {
        if (eventData.responseData.paymentMethod === this.options.paymentMethod) {
            eventData.stopped = true;
            if (eventData.responseData.nnSuccess == true) {
                if (eventData.responseData.nnRedirectUrl) {
                    window.location = eventData.responseData.nnRedirectUrl;
                    return;
                }
                mediator.execute('redirectTo', {url: eventData.responseData.successUrl}, {redirect: true});
            } else {
                mediator.execute('redirectTo', {url: eventData.responseData.errorUrl}, {redirect: true});
            }
        }
    },

    dispose: function() {
        if (this.disposed) {
            return;
        }
        mediator.off('checkout:place-order:response', this.handleSubmit, this);
        NovalnetComponent.__super__.dispose.call(this);
    }
});

export default NovalnetComponent;
