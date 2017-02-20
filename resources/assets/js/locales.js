export default {
    "de": {
        "action": {
            "edit_profile": "Profil bearbeiten",
            "login": "Anmelden",
            "register": "Registrieren",
            "register_as_athlete": "Als Athlet registrieren",
            "register_as_organizer": "Als Veranstalter registrieren",
            "logout": "Abmelden",
            "confirm_account": "Account bestätigen"
        },
        "alert": {
            "error": {
                "delete": {
                    "title": "Löschen fehlgeschlagen",
                    "content": "Beim Löschen von {name} ist ein Fehler aufgetreten. Versuche es noch einmal."
                },
                "post": {
                    "title": "Sorry!",
                    "content": "Beim Speichern ist ein Fehler aufgetreten. Versuche es noch einmal."
                },
                "put": {
                    "title": "Sorry!",
                    "content": "Beim Aktualisieren von {name} ist ein Fehler aufgetreten. Versuche es noch einmal."
                }
            },
            "default": {
                "delete": {
                    "title": "Gelöscht!",
                    "content": "{name} wurde erfolgreich gelöscht."
                },
                "post": {
                    "title": "Gespeichert!",
                    "content": "Dein Objekt wurde erfolgreicht erstellt."
                },
                "put": {
                    "title": "Gespeichert!",
                    "content": "{name} wurde erfolgreich aktualisiert."
                }
            },
            "registration": {
                "post": {
                    "title": "Account bestätigen!",
                    "content": "Wir haben dir eine E-Mail an deine E-Mail-Adresse gesendet. Bitte klicke auf den darin enthaltenen Link, um deinen Account und deine E-Mail-Adresse zu bestätigen."
                }
            },
            "account_confirmed": {
                "title": "Account bestätigt!",
                "content": "Dein Account und deine E-Mail-Adresse wurde erfolgreich bestätigt. Du kannst dich nun einloggen."
            },
            "password_reset": {
                "post": {
                    "title": "Passwort zurückgesetzt",
                    "content": "Dein Passwort wurde erfolgreich zurückgesetzt."
                }
            },
            "password_forgot": {
                "post": {
                    "title": "E-Mail gesendet!",
                    "content": "Wir haben dir eine E-Mail zum Zurücksetzen deines Passworts zugeschickt."
                }
            }
        },
        "auth": {
            "failed": "These credentials do not match our records.",
            "throttle": "Too many login attempts. Please try again in {seconds} seconds."
        },
        "email": {
            "greeting": "Hallo {name}",
            "greeting_plain": "Hallo",
            "salutation": "Viele Grüße",
            "extra": "Falls du Probleme hast den \"{button}\" Button zu klicken, kopiere den folgenden Link und füge ihn in deinen Browser ein{}",
            "contact": {
                "title": "Neue Kontaktnachricht über die Website"
            },
            "registration": {
                "title": "Deine Registrierung bei {title}",
                "content": "vielen Dank für deine Registrierung als {user_type} bei {title}. Bitte klicke auf den folgenden Link, um deine E-Mail-Adresse und damit deinen Account zu bestätigen. Bitte beachte, dass du dich erst bei {title} anmelden kannst, nachdem du deinen Acount bestätigt hast."
            },
            "password_reset": {
                "title": "{title}{} Dein neues Passwort",
                "content": "du hast soeben ein neues Passwort für deinen Account bei {title} angefragt. Klicke auf den folgenden Button, um dein Passwort zurückzusetzen. Solltest du nicht um eine Zurücksetzung deines Passworts gebeten haben, so kannst du diese E-Mail ignorieren."
            }
        },
        "info": [],
        "input": {
            "search": "Suche",
            "password": "Passwort",
            "password_confirmation": "Passwort bestätigen",
            "email": "E-Mail-Adresse",
            "gender": "Geschlecht",
            "first_name": "Vorname",
            "last_name": "Nachname",
            "display_name": "Anzeigename",
            "birthday": "Geburtstag",
            "remember_me": "Angemeldet bleiben",
            "name": "Name",
            "message": "Nachricht",
            "url": "Website URL",
            "twitter": "Twitter Name",
            "facebook": "Facebook Slug",
            "github": "Github Name",
            "linkedin": "LinkedIn Name",
            "instagram": "Instagram Name",
            "user_type": "Als Veranstalter registrieren?"
        },
        "label": {
            "profile": "Profil",
            "forgot_my_password": "Passwort vergessen?",
            "not_registered": "Noch keinen Account? Jetzt registrieren!",
            "male": "Männlich",
            "female": "Weiblich"
        },
        "pagination": {
            "previous": "&laquo; Previous",
            "next": "Next &raquo;"
        },
        "passwords": {
            "password": "Passwords must be at least six characters and match the confirmation.",
            "reset": "Your password has been reset!",
            "sent": "We have e-mailed your password reset link!",
            "token": "This password reset token is invalid.",
            "user": "We can't find a user with that e-mail address."
        },
        "validation": {
            "accepted": "The {attribute} must be accepted.",
            "active_url": "The {attribute} is not a valid URL.",
            "after": "The {attribute} must be a date after {date}.",
            "after_or_equal": "The {attribute} must be a date after or equal to {date}.",
            "alpha": "The {attribute} may only contain letters.",
            "alpha_dash": "The {attribute} may only contain letters, numbers, and dashes.",
            "alpha_num": "The {attribute} may only contain letters and numbers.",
            "array": "The {attribute} must be an array.",
            "before": "The {attribute} must be a date before {date}.",
            "before_or_equal": "The {attribute} must be a date before or equal to {date}.",
            "between": {
                "numeric": "The {attribute} must be between {min} and {max}.",
                "file": "The {attribute} must be between {min} and {max} kilobytes.",
                "string": "The {attribute} must be between {min} and {max} characters.",
                "array": "The {attribute} must have between {min} and {max} items."
            },
            "boolean": "The {attribute} field must be true or false.",
            "confirmed": "Die Eingabe stimmt mit der {attribute} Eingabe nicht überein.",
            "date": "The {attribute} is not a valid date.",
            "date_format": "The {attribute} does not match the format {format}.",
            "different": "The {attribute} and {other} must be different.",
            "digits": "The {attribute} must be {digits} digits.",
            "digits_between": "The {attribute} must be between {min} and {max} digits.",
            "dimensions": "The {attribute} has invalid image dimensions.",
            "distinct": "The {attribute} field has a duplicate value.",
            "email": "Bitte gebe eine gültige E-Mail-Adresse ein.",
            "exists": "The selected {attribute} is invalid.",
            "file": "The {attribute} must be a file.",
            "filled": "The {attribute} field is required.",
            "image": "The {attribute} must be an image.",
            "in": "The selected {attribute} is invalid.",
            "in_array": "The {attribute} field does not exist in {other}.",
            "integer": "The {attribute} must be an integer.",
            "ip": "The {attribute} must be a valid IP address.",
            "json": "The {attribute} must be a valid JSON string.",
            "max": {
                "numeric": "The {attribute} may not be greater than {max}.",
                "file": "The {attribute} may not be greater than {max} kilobytes.",
                "string": "Bitte gebe max. {max} Zeichen ein.",
                "array": "The {attribute} may not have more than {max} items."
            },
            "mimes": "The {attribute} must be a file of type{} {values}.",
            "mimetypes": "The {attribute} must be a file of type{} {values}.",
            "min": {
                "numeric": "The {attribute} must be at least {min}.",
                "file": "The {attribute} must be at least {min} kilobytes.",
                "string": "Bitte gebe mind. {min} Zeichen ein.",
                "array": "The {attribute} must have at least {min} items."
            },
            "not_in": "The selected {attribute} is invalid.",
            "numeric": "The {attribute} must be a number.",
            "present": "The {attribute} field must be present.",
            "regex": "The {attribute} format is invalid.",
            "required": "Bitte fülle dieses Feld aus.",
            "required_if": "The {attribute} field is required when {other} is {value}.",
            "required_unless": "The {attribute} field is required unless {other} is in {values}.",
            "required_with": "The {attribute} field is required when {values} is present.",
            "required_with_all": "The {attribute} field is required when {values} is present.",
            "required_without": "The {attribute} field is required when {values} is not present.",
            "required_without_all": "The {attribute} field is required when none of {values} are present.",
            "same": "The {attribute} and {other} must match.",
            "size": {
                "numeric": "The {attribute} must be {size}.",
                "file": "The {attribute} must be {size} kilobytes.",
                "string": "Bitte gebe mind. {size} Zeichen ein.",
                "array": "The {attribute} must contain {size} items."
            },
            "string": "The {attribute} must be a string.",
            "timezone": "The {attribute} must be a valid zone.",
            "unique": "The {attribute} has already been taken.",
            "uploaded": "The {attribute} failed to upload.",
            "url": "The {attribute} format is invalid.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": []
        }
    },
    "en": {
        "auth": {
            "failed": "These credentials do not match our records.",
            "throttle": "Too many login attempts. Please try again in {seconds} seconds."
        },
        "pagination": {
            "previous": "&laquo; Previous",
            "next": "Next &raquo;"
        },
        "passwords": {
            "password": "Passwords must be at least six characters and match the confirmation.",
            "reset": "Your password has been reset!",
            "sent": "We have e-mailed your password reset link!",
            "token": "This password reset token is invalid.",
            "user": "We can't find a user with that e-mail address."
        },
        "validation": {
            "accepted": "The {attribute} must be accepted.",
            "active_url": "The {attribute} is not a valid URL.",
            "after": "The {attribute} must be a date after {date}.",
            "after_or_equal": "The {attribute} must be a date after or equal to {date}.",
            "alpha": "The {attribute} may only contain letters.",
            "alpha_dash": "The {attribute} may only contain letters, numbers, and dashes.",
            "alpha_num": "The {attribute} may only contain letters and numbers.",
            "array": "The {attribute} must be an array.",
            "before": "The {attribute} must be a date before {date}.",
            "before_or_equal": "The {attribute} must be a date before or equal to {date}.",
            "between": {
                "numeric": "The {attribute} must be between {min} and {max}.",
                "file": "The {attribute} must be between {min} and {max} kilobytes.",
                "string": "The {attribute} must be between {min} and {max} characters.",
                "array": "The {attribute} must have between {min} and {max} items."
            },
            "boolean": "The {attribute} field must be true or false.",
            "confirmed": "The {attribute} confirmation does not match.",
            "date": "The {attribute} is not a valid date.",
            "date_format": "The {attribute} does not match the format {format}.",
            "different": "The {attribute} and {other} must be different.",
            "digits": "The {attribute} must be {digits} digits.",
            "digits_between": "The {attribute} must be between {min} and {max} digits.",
            "dimensions": "The {attribute} has invalid image dimensions.",
            "distinct": "The {attribute} field has a duplicate value.",
            "email": "The {attribute} must be a valid email address.",
            "exists": "The selected {attribute} is invalid.",
            "file": "The {attribute} must be a file.",
            "filled": "The {attribute} field is required.",
            "image": "The {attribute} must be an image.",
            "in": "The selected {attribute} is invalid.",
            "in_array": "The {attribute} field does not exist in {other}.",
            "integer": "The {attribute} must be an integer.",
            "ip": "The {attribute} must be a valid IP address.",
            "json": "The {attribute} must be a valid JSON string.",
            "max": {
                "numeric": "The {attribute} may not be greater than {max}.",
                "file": "The {attribute} may not be greater than {max} kilobytes.",
                "string": "The {attribute} may not be greater than {max} characters.",
                "array": "The {attribute} may not have more than {max} items."
            },
            "mimes": "The {attribute} must be a file of type{} {values}.",
            "mimetypes": "The {attribute} must be a file of type{} {values}.",
            "min": {
                "numeric": "The {attribute} must be at least {min}.",
                "file": "The {attribute} must be at least {min} kilobytes.",
                "string": "The {attribute} must be at least {min} characters.",
                "array": "The {attribute} must have at least {min} items."
            },
            "not_in": "The selected {attribute} is invalid.",
            "numeric": "The {attribute} must be a number.",
            "present": "The {attribute} field must be present.",
            "regex": "The {attribute} format is invalid.",
            "required": "The {attribute} field is required.",
            "required_if": "The {attribute} field is required when {other} is {value}.",
            "required_unless": "The {attribute} field is required unless {other} is in {values}.",
            "required_with": "The {attribute} field is required when {values} is present.",
            "required_with_all": "The {attribute} field is required when {values} is present.",
            "required_without": "The {attribute} field is required when {values} is not present.",
            "required_without_all": "The {attribute} field is required when none of {values} are present.",
            "same": "The {attribute} and {other} must match.",
            "size": {
                "numeric": "The {attribute} must be {size}.",
                "file": "The {attribute} must be {size} kilobytes.",
                "string": "The {attribute} must be {size} characters.",
                "array": "The {attribute} must contain {size} items."
            },
            "string": "The {attribute} must be a string.",
            "timezone": "The {attribute} must be a valid zone.",
            "unique": "The {attribute} has already been taken.",
            "uploaded": "The {attribute} failed to upload.",
            "url": "The {attribute} format is invalid.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": []
        }
    }
}
