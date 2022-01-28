import React from "react";

import 'bootstrap/dist/css/bootstrap.min.css';

import { Container, Row } from 'react-bootstrap';

import Header from './components/Header';
import Jumbotron from './components/Jumbotron';
import Messages from './components/Messages';
import Sidebar from './components/Sidebar';
import CreateMessageModal from './components/CreateMessageModal';

class App extends React.Component {
    
    constructor(props) {
        super(props);
        
        this.state = {
            loading:false,
            messages: [],
            response: {
                body: {}
            },
            request: {
                url: '',
                body: {}
            }
        };
    }
    
    // grab configs from script on views/playground.blade.php
    configs = window.PlaygroundConfig;
    
    // reference to Modal to be able to show/hide
    createMessageModalRef = ({handleShow, handleClose}) => {
        this.showCreateMessageModal = handleShow;
        this.hideCreateMessageModal = handleClose;
    }
    
    
    fetchMessages = () => {
        
        var url = this.configs.api_root + '/list/' + this.configs.api_key_id;
        
        this.setState({
            ...this.state,
            loading: true,
            messages: []
        });
        
        return fetch(url,{headers: this.configs.headers})
        .then(async (response) => {
            return {
                request : {
                    url: url,
                    body: {}
                },
                response: {
                    
                    // wait for the response to resolve
                    body: await response.json()
                }
            };
        });
    }
    
    createMessage = (request) => {
        
        var url = this.configs.api_root + '/create';
        
        fetch(url,
        {
            method: 'POST',
            headers: {
                ...this.configs.headers,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(request)
        })
        .then( response => response.json())
        .then( (body) => {
            
            this.hideCreateMessageModal();
            
            this.fetchMessages()
            .then((result) => {
                
                this.setState({
                    ...this.state,
                    loading: false,
                    messages: result.response.body.data.reverse(),
                    request: {
                        url: url,
                        body: request
                    },
                    response: {
                        body:body
                    }
                });
            });
        });
    }
    
    componentDidMount() {
        
        //fetch message on page load
        this.fetchMessages()
        .then((result) => {
            
            this.setState({
                ...this.state,
                loading: false,
                messages: result.response.body.data.reverse(),
                request: result.request,
                response: result.response
            });
        });
    }
    
    render() {
     
        return(
            <>
            
            <Container fluid >
                <Header />
                
                <Row className="mt-1">
                
                    <Jumbotron createMessage={this.createMessage} showCreateMessageModal={this.showCreateMessageModal} />
                    
                    <Messages loading={this.state.loading} messages={this.state.messages} />
                    
                    <Sidebar request={this.state.request} response={this.state.response} />
                
                </Row>
            </Container>
            
            <CreateMessageModal ref={this.createMessageModalRef} createMessage={this.createMessage} />
            
            </>
        );
    }
}

export default App;