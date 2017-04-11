module.exports = class Form {

    /**
     * Creates a new Form instance.
     *
     * @param {object} data
     */
    constructor(data = null) {
        this.data = data ? data : {};
    }

    /**
     * Adds the specified field with its value to the forms data.
     *
     * @param field
     * @param value
     */
    set(field, value) {
        this.data[field] = value;
    }

    /**
     * Determines if the form contains the specified field.
     *
     * @param {string} field
     * @returns {boolean}
     */
    has(field) {
        return this.data.hasOwnProperty(field);
    }

    /**
     * Gets the data that will be submitted.
     *
     * @returns {{}}
     */
    getSubmitData() {
        let submitData = {};
        for (let key in this.data) {
            let value = this.data[key];
            if (value !== '' && value !== null) {
                submitData[key] = value;
            }
        }

        return submitData;
    }

    /**
     * Sends a POST request to the given URL.
     *
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }

    /**
     * Sends a PUT request to the given URL.
     *
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }

    /**
     * Sends a PATCH request to the given URL.
     *
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }

    /**
     * Sends a DELETE request to the given URL.
     *
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }

    /**
     * Submits the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: requestType.toLowerCase(),
                url: url,
                data: this.getSubmitData(),
                success: response => {
                    resolve(response);
                },
                error: error => {
                    reject(error.responseJSON);
                }
            });
        });
    }
};