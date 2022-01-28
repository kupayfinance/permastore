import React from 'react';
import {Col, Card} from 'react-bootstrap';

class Sidebar extends React.Component {
    
    render() {
        
        return (
            <Col xs={4}>
                <Card>
                    <Card.Header>Request</Card.Header>
                    <Card.Body>
                        <p><u><i><strong>{this.props.request.url}</strong></i></u></p>
                        <pre>{JSON.stringify(this.props.request.body, undefined, 2)}</pre>
                    </Card.Body>
                </Card>
                <Card className="mt-2">
                    <Card.Header>Response</Card.Header>
                    <Card.Body>
                        <pre>{JSON.stringify(this.props.response.body, undefined, 2)}</pre>
                    </Card.Body>
                </Card>
            </Col>
        );
    }
};

export default Sidebar;