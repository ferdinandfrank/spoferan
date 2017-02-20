module.exports = {
    props: {
        // The selector of the element to show on activation.
        activate: {
            type: String,
            required: true
        },
        // The duration of the transition enter in milliseconds.
        inDuration: {
            type: Number,
            default: 300
        },

        // The duration of the transition out in milliseconds.
        outDuration: {
            type: Number,
            default: 225
        },

        // If true, constrainWidth to the size of the dropdown activator.
        constrainWidth: {
            type: Boolean,
            default: true
        },

        // If true, the dropdown will open on hover.
        hover: {
            type: Boolean,
            default: false
        },

        // This defines the spacing from the aligned edge.
        gutter: {
            type: Number,
            default: 0
        },

        // If true, the dropdown will show below the activator.
        belowOrigin: {
            type: Boolean,
            default: true
        },

        // Defines the edge the menu is aligned to.
        // Valid values: 'right', 'left', 'none'
        alignment: {
            type: String,
            default: 'right'
        }
    },

    computed: {
        dropdownContent: function () {
            return $(this.activate);
        },
        dropdownButton: function () {
            return $(this.$el);
        }
    },

    methods: {

        activateDropdown: function () {
            if (!this.dropdownContent.hasClass('active')) {
                this.showDropdownContent();
            }
        },

        toggleDropdown: function () {
            if (this.dropdownContent.hasClass('active')) {
                this.hideDropdownContent();
            } else {
                this.showDropdownContent();
            }
        },

        showDropdownContent: function () {

            // Set Dropdown state
            this.dropdownContent.addClass('active');
            this.dropdownButton.addClass('active');

            // Constrain width
            if (this.constrainWidth) {
                this.dropdownContent.css('width', this.dropdownButton.outerWidth());

            } else {
                this.dropdownContent.css('white-space', 'nowrap');
            }

            // Offscreen detection
            var windowHeight = window.innerHeight;
            var originHeight = this.dropdownButton.innerHeight();
            var offsetLeft = this.dropdownButton.offset().left;
            var offsetTop = this.dropdownButton.offset().top - $(window).scrollTop();
            var currAlignment = this.alignment;
            var gutterSpacing = 0;
            var leftPosition = this.dropdownContent.css('left');

            var verticalOffset = this.dropdownContent.css('top');
            if (this.belowOrigin === true) {
                verticalOffset = originHeight;
            }

            // Check for scrolling positioned container.
            var scrollYOffset = 0;
            var scrollXOffset = 0;
            var wrapper = this.dropdownButton.parent();
            if (!wrapper.is('body')) {
                if (wrapper[0].scrollHeight > wrapper[0].clientHeight) {
                    scrollYOffset = wrapper[0].scrollTop;
                }
                if (wrapper[0].scrollWidth > wrapper[0].clientWidth) {
                    scrollXOffset = wrapper[0].scrollLeft;
                }
            }

            if (currAlignment != 'none' && offsetLeft + this.dropdownContent.innerWidth() > $(window).width()) {
                // Dropdown goes past screen on right, force right alignment
                currAlignment = 'right';

            } else if (currAlignment != 'none' && offsetLeft - this.dropdownContent.innerWidth() + this.dropdownButton.innerWidth() < 0) {
                // Dropdown goes past screen on left, force left alignment
                currAlignment = 'left';
            }
            // Vertical bottom offscreen detection
            if (offsetTop + this.dropdownContent.innerHeight() > windowHeight) {
                // If going upwards still goes offscreen, just crop height of dropdown.
                if (offsetTop + originHeight - this.dropdownContent.innerHeight() < 0) {
                    var adjustedHeight = windowHeight - offsetTop - verticalOffset;
                    this.dropdownContent.css('max-height', adjustedHeight);
                } else {
                    // Flow upwards.
                    if (!verticalOffset) {
                        verticalOffset += originHeight;
                    }
                    verticalOffset -= this.dropdownContent.innerHeight();
                }
            }

            // Handle edge alignment
            if (currAlignment === 'left') {
                gutterSpacing = this.gutter;
                leftPosition = this.dropdownButton.position().left + gutterSpacing;
            }
            else if (currAlignment === 'right') {
                var offsetRight = this.dropdownButton.position().left + this.dropdownButton.outerWidth() - this.dropdownContent.outerWidth();
                gutterSpacing = -this.gutter;
                leftPosition = offsetRight + gutterSpacing;
            }

            // Position dropdown
            this.dropdownContent.css({
                position: 'absolute',
                top: this.dropdownButton.position().top + verticalOffset + scrollYOffset,
                left: leftPosition + scrollXOffset
            });


            // Show dropdown
            this.dropdownContent.stop(true, true).css('opacity', 0)
                .slideDown({
                    queue: false,
                    duration: this.inDuration,
                    easing: 'easeOutCubic',
                    complete: function () {
                        $(this).css('height', '');
                    }
                })
                .animate({opacity: 1}, {queue: false, duration: this.inDuration, easing: 'easeOutSine'});

            this.initDropdownClosing();
        },

        hideDropdownContent: function () {
            this.dropdownContent.fadeOut(this.outDuration);
            this.dropdownContent.removeClass('active');
            this.dropdownButton.removeClass('active');
            setTimeout(() => {
                this.dropdownContent.css('max-height', '');
            }, this.outDuration);
        },

        /**
         * Initializes the listener to close the dropdown content, if the user clicks next to the open dropdown content.
         */
        initDropdownClosing: function () {
            if (this.dropdownContent.hasClass('active')) {
                $(document).bind('click.' + this.dropdownContent.attr('id') + ' touchstart.' + this.dropdownContent.attr('id'), (e) => {
                    if (!this.dropdownContent.is(e.target) && !this.dropdownButton.is(e.target) && (!this.dropdownButton.find(e.target).length)) {
                        this.hideDropdownContent();
                        $(document).unbind('click.' + this.dropdownContent.attr('id') + ' touchstart.' + this.dropdownContent.attr('id'));
                    }
                });
            }
        }
    }
};

