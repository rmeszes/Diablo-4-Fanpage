function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,})?$/;
    return emailReg.test( $email );
}

/**
 * Function to check if a character is alpha-numeric.
 *
 * @param {string} c
 * @return {boolean}
 */
function isAlphaNumeric(c) {
  const CHAR_CODE_A = 65;
  const CHAR_CODE_Z = 90;
  const CHAR_CODE_AS = 97;
  const CHAR_CODE_ZS = 122;
  const CHAR_CODE_0 = 48;
  const CHAR_CODE_9 = 57;

  let code = c.charCodeAt(0);

  if (
    (code >= CHAR_CODE_A && code <= CHAR_CODE_Z) ||
    (code >= CHAR_CODE_AS && code <= CHAR_CODE_ZS) ||
    (code >= CHAR_CODE_0 && code <= CHAR_CODE_9)
  ) {
    return true;
  }

  return false;
}

/**
 * Function to check if a string is fully alpha-numeric.
 *
 * @param {string} s
 * @returns {boolean}
 */
function isAlphaNumericString(s) {
  for (let i = 0; i < s.length; i++) {
    if (!isAlphaNumeric(s[i])) {
      return false;
    }
  }

  return true;
}

