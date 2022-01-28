import React from 'react';

import {Modal, Form, Button} from 'react-bootstrap';

class CreateMessageModal extends React.Component {
    
    constructor(props) {
        super(props);
        
        this.state = {
            show: false,
            submitting: false
        };
        
        this.handleShow = this.handleShow.bind(this);
        this.handleClose = this.handleClose.bind(this);
    }
    
    handleShow = () => {
        this.setState({ show: true })
    }
    handleClose = () => {
        this.setState({
            show: false,
            submitting: false
        })
    }
    
    handleSubmit = (event) => {
        event.preventDefault();
        
        const inputs = event.target.elements;
        
        this.setState({
            ...this.state,
            submitting: true
        })
        
        this.props.createMessage({
            data: {
                message: {
                    contents : inputs.namedItem('request_content').value,
                    format   : inputs.namedItem('request_type').value,
                }
            }
        })
        
        return false;
    }
    
    render() {
        return (
            <Modal show={this.state.show} onHide={this.handleClose}>
                <Form onSubmit={this.state.submitting ? null : this.handleSubmit}>
                    <Modal.Header closeButton>
                        <Modal.Title>Create New Message</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        
                        
                        <Form.Group controlId="request_content">
                            <Form.Label>Content</Form.Label>
                            <Form.Control required as="textarea" rows={3} />
                            <Form.Text className="text-muted">
                                The content to be stored on the blockchain. Max. 64 character
                            </Form.Text>
                        </Form.Group>
                        
                        <Form.Group controlId="request_type">
                            <Form.Label>Type</Form.Label>
                            <Form.Control as="select">
                                <option value="plaintext">Plain Text</option>
                                <option value="hex">Hexadecimal (SHA256)</option>
                            </Form.Control>
                        </Form.Group>
                        
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="outline-secondary" onClick={this.handleClose}>Close</Button>
                        <Button
                            type="submit"
                            variant="outline-primary"
                            disabled={this.state.submitting}
                        >
                            {this.state.submitting ? 'Submitting…' : 'Create'}
                        </Button>
                    </Modal.Footer>
                </Form>
            </Modal>
        );
    }
};

export default CreateMessageModal;