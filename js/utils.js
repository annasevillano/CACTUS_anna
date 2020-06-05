/**
 * Returns number with thousand separators or if number is 0 replaces it with a -.
 *
 * @param {number} num The number that needs to be reformatted.
 * @return {string} A string of the number in the new format.
 */
function formatThousandNumber(num) {
    var return_val = "-";
    if(num >= 0.01){
        return_val = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    return return_val;
}

/**
 * Adds currency symbol and thousand separators to number.
 *
 * @param {number} num The number that needs to be reformatted.
 * @return {string} A string of the number in the new format.
 */
function currencyThousandFormat(num) {
    return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

Array.prototype.sortUnique = function sortUnique() {
    this.sort();
    var last_i;
    for (var i=0;i<this.length;i++)
        if ((last_i = this.lastIndexOf(this[i])) !== i)
            this.splice(i+1, last_i-i);
    return this;
};

function download_text_string_as_file(string_body_of_file,filename){
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(string_body_of_file));
    //var filename ="total_costs_by_component_chart_data.csv";
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}
