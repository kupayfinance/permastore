import React from 'react';

import {Col, Card, Table} from 'react-bootstrap';

import Message from './Message';

class Messages extends React.Component {
    
    render() {
        return (
            <Col xs={8}>
                <Card>
                    <Card.Header>Your Messages</Card.Header>
                    <Card.Body>
                        <Table responsive striped>
                            <thead>
                            <tr>
                            <th scope="col" style={{width: "50%"}}>info</th>
                            <th scope="col">created</th>
                            <th scope="col">status</th>
                            </tr>
                            </thead>
                                <tbody>
                                
                                    { !this.props.loading && !this.props.messages.length && <tr><td colSpan={3}><i className="text-muted">Create New Message to Start</i></td></tr>}
                                    
                                    { this.props.loading &&  <tr><td colSpan={3}><i className="text-muted">Loading Messages...</i></td></tr>}
                                    
                                    {this.props.messages.map((message, index) => (
                                        
                                        <Message message={message} key={index} index={index} />
                                        
                                    ))}
                                
                                </tbody>
                        </Table>
                    </Card.Body>
                </Card>
            </Col>
        );
    }
};

export default Messages;