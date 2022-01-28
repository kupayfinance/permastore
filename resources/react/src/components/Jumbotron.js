import React from 'react';

import {Col, Jumbotron as BSJumbotron, Button} from 'react-bootstrap';

class Jumbotron extends React.Component {
    
    render() {
        
        return (
            <Col xs={12}>
                <BSJumbotron className='p-4'>
                    <h1 className="display-4">The Playground</h1>
                    <p className="lead">
                        Modern block chains allow you to send tokens to other accounts, execute smart contracts and store arbitrary information.
                        It is irrevocable, permanent and highly secure.
                    </p>
                    <h3>What can I do here?</h3>
                    <p className="lead">
                        How about storing a short, permanent message on the block chain for free?
                        We will launch this service as an API for software applications soon!
                    </p>
                    <p className="lead">
                        <strong>Applications</strong> can use our API to automatically store a fingerprint of their documents (SHA256) on the block chain.<br/>
                        The document + the finger print + transaction receipt prove that you had that information at that point in time.
                    </p>
                    <p className="lead">
                        <Button variant="outline-primary" size="lg" href="https://forms.gle/HsSLb7Gs82W2Neju9" target="_blank" rel="noreferrer noopener">Sign up</Button>{' '}
                        <Button variant="primary" size="lg" onClick={this.props.showCreateMessageModal}>New Message</Button>
                    </p>
                </BSJumbotron>
            </Col>
        );
    }
};

export default Jumbotron;