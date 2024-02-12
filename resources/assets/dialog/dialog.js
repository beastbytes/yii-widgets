/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 *
 * Controls the opening and closing of the dialog.
 *
 * Add the `data-open-dialog` attribute with its value set the dialog id, to elements that will open the dialog when
 * clicked.
 * If the dialog is not to be modal (modal is the default) also add the `data-is-modal` attribute set to the string
 * "false".
 * Add the `data-close-dialog` attribute to element(s) within the dialog that will close the dialog when clicked.
 */

const dialog = {
    init: function () {
        for (const el of document.querySelectorAll("[data-open-dialog]")) {
            el.addEventListener("click", function () {
                const dialog = document.getElementById(this.dataset.openDialog)
                if (this.dataset.isModal === 'false') {
                    dialog.show()
                } else {
                    dialog.showModal()
                }
            })
        }

        for (const el of document.querySelectorAll("[data-close-dialog]")) {
            el.addEventListener("click", function () {
                this.closest("dialog").close()
            })
        }
    }
}

dialog.init()
