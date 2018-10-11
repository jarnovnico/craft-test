import _ from 'lodash';
import '../sass/main.scss';
import Icon from '../images/yoda-young.png';

function component() {
    let element = document.createElement('div');

    element.innerHTML = _.join(['Hello', 'webpack'], ' ');
    element.classList.add('hello');

    // Add the image to our existing div.
    var myIcon = new Image();
    myIcon.src = Icon;

    element.appendChild(myIcon);

    return element;

    // Apply transition
    Barba.Pjax.getTransition = () => FadeTransition;

    // Start transition
    Barba.Pjax.start();
}

document.body.appendChild(component());