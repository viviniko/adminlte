require('./adminlte');

window.moment = require('moment');

window.daterangepicker = require('daterangepicker');

window.swal = require('sweetalert');

window.toastr = require('toastr');

require('jstree');

(function() {

    var application = {

        loader: {
            el: '#content-loader',

            init: function(el) {
                this.el = el || this.el;
            },

            hide: function() {
                $(this.el).fadeOut();
            },

            show: function() {
                $(this.el).show();
            }
        },

        modaler: {
            counter: 0,

            init: function() {
                var that = this, app = application;
                $('body').on('click', 'a[target="_modal"]', function(e) {
                    var $link = $(this);
                    var options = $.extend({
                        'url': $link.attr('href'),
                        'title': $link.data('original-title') || $link.attr('title'),
                        'init': $link.data('modal-init'),
                        'init-failure': $link.data('modal-init-failure')
                    }, $link.data('options') || {});
                    that.customInit(options.init, function(initReturn) {
                        options = $.extend(options, initReturn);
                        that.createModal(options);
                    }, function(initReturn) {
                        if (options['init-failure'])
                            swal({title:$link.data('modal-init-failure'), type:'info'});
                    });
                    e.preventDefault();
                }).on('click', 'button[target="_modal"]', function(e) {
                    e.preventDefault();
                });
            },

            customInit: function(modalInit, success, error) {
                var modalOptions = {};
                if (modalInit) {
                    modalOptions = eval(modalInit);
                    if (modalOptions === false) {
                        error(modalOptions);
                        return;
                    }
                }
                success(modalOptions);
            },

            createModal: function (options) {
                options = $.extend({
                    id: ('modaler-' + ++this.counter),
                    header: true,
                    footer: true,
                    container: 'body'
                }, options || {});

                var that = this;
                var loader = application.loader;
                var $modal = $('<div class="modal fade" id="' + options.id + '" tabindex="-1" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>');
                var $modalHeader = $modal.find('.modal-header');
                var $modalBody = $modal.find('.modal-body');
                var $modalFooter = $modal.find('.modal-footer');
                if (options.header) {
                    if (options.title)
                        $modalHeader.append('<h4 class="modal-title">' + options.title + '</div>');
                } else {
                    $modalHeader.remove();
                }
                if (options.body) {
                    $modalBody.append('<h4 class="modal-title">' + options.body + '</div>');
                }
                if (options.footer) {
                    $modalFooter.append(options.buttons);
                } else {
                    $modalFooter.remove();
                }

                $modal.appendTo(options.container)
                    .on('show.bs.modal', function() {
                        if (options.url) {
                            loader.show();
                            $modalBody.load(options.url, function() {
                                application.boot();
                                if (options.loaded) {
                                    eval(options.loaded);
                                }
                            });
                        }
                    })
                    .on('hidden.bs.modal', function() {
                        $modal.remove();
                    }).modal();
            }
        },

        linker: {
            init: function() {
                var that = this;
                $('body').on('click', 'a[data-method]', function(e) {
                    var $link = $(this);
                    var httpMethod = $link.data('method').toUpperCase();

                    // If the data-method attribute is not POST or PUT or DELETE,
                    // then we don't know what to do. Just ignore.
                    if ( $.inArray(httpMethod, ['POST', 'PUT', 'DELETE']) === -1 ) {
                        return;
                    }

                    var options = $.extend({"action":$link.attr('href'),"method":httpMethod}, $link.data('options') || {});
                    if (!options.init || eval(options.init)) {
                        that.verifyConfirm(options, function (t) {
                            if (! t) return false;
                            that.doAction(options);
                        })
                    } else {
                        swal({title:options['init-failure'] || 'Something Errors!', type:'info'});
                    }

                    e.preventDefault();
                });
            },

            verifyConfirm: function(options, callback) {
                var titles = {'DELETE':'delete', 'PUT':'save', 'POST': 'save'};
                swal({
                    title: options['confirm-title'] || 'Please confirm',
                    text: options['confirm-text'] || 'Are you sure ' + titles[options.method] + '?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: options['confirm-action'] || "Yes",
                }, function (t) {
                    callback(t)
                })
            },

            doAction: function(options) {
                var that = this;
                var $form = that.createForm(options);
                if (options.done) { // need callback
                    $.ajax({
                        type: $form.attr('method'),
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        success: function() {
                            eval(options.done);
                        }
                    });
                } else {
                    $form.submit();
                }
            },

            createForm: function(options) {
                var app = application;

                var form =
                    $('<form>', {
                        'method': 'POST',
                        'action': options.action
                    });

                var token =
                    $('<input>', {
                        'name': '_token',
                        'type': 'hidden',
                        'value': app.csrfToken
                    });

                var hiddenInput =
                    $('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': options.method
                    });

                var createFormFunc = options['create-form'];
                if (createFormFunc) {
                    var postData = eval(createFormFunc);
                    if (typeof postData == 'string') {
                        var items = postData.split('&');
                        postData = {};
                        for (var i=0; i<items.length; i++) {
                            var item = items[i].split('=');
                            postData[item[0]] = [item[1]];
                        }
                    }
                    $.each(postData, function(n, v) {
                        form.append($('<input>', {
                            'name': n,
                            'type': 'hidden',
                            'value': v
                        }));
                    });
                }

                return form.append(token, hiddenInput)
                    .appendTo('body');
            }
        },

        initialize: function() {
            var that = this;
            $(document).ready(function() {
                that.csrfToken = $('meta[name="csrf-token"]').attr('content');
                that.loader.init();
                that.modaler.init();
                that.linker.init();
                that.boot();
            });
        },

        boot: function() {
            var that = this;
            that.loader.hide();
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $("a[data-toggle=loader], button[data-toggle=loader]").click(function () {
                if ($(this).parents('form').valid()) {
                    that.loader.show();
                    $(this).parents('form').submit();
                }
            });
            $('[data-loading=loader]').click(function(){
                that.loader.show();
            });
            $('select').filter('.select2').select2({minimumResultsForSearch: 10});
            $('input.icheck').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        },


    };

    application.initialize();

})(window);