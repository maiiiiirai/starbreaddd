export function globalListener(typeOfEvent, element, callback) {
    element.addEventListener(typeOfEvent, (e) => {
        e.preventDefault();
        callback(e);
    });
}