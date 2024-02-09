
/**
 * @param {string} value
 * @returns {boolean}
 */
export const isEmpty = (value) => value.trim().length === 0;


/**
 * @param {string} value
 * @returns {boolean}
 */
export const isEmail = (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

/**
 * @param {object} value
 * @returns {boolean}
 */
export const isKeysEmpty = (value) => Object.keys(value).length === 0 && Object.keys(value)
    .every((key) => isEmpty(value[key]));

/**
 * @param {string} value
 * @returns {boolean}
 */
export const isNotNumeric = (value) => !/^[a-zA-ZğüşıöçĞÜŞİÖÇ\s]+$/.test(value);