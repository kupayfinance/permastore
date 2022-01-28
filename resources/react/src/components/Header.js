import React from 'react';

import { Navbar, Nav,NavDropdown } from 'react-bootstrap';

const Header = () => {
    
    return (
        <Navbar bg="light" expand="lg">
            <Navbar.Brand href="/">Perma Store</Navbar.Brand>
            <Navbar.Toggle aria-controls="navbarSupportedContent" />
            <Navbar.Collapse id="navbarSupportedContent">
                <Nav className="mr-auto">
                    <Nav.Link href="/">Home</Nav.Link>
                    <Nav.Link href="/playground">Playground</Nav.Link>
                    <NavDropdown title="Learn More" id="basic-nav-dropdown">
                        
                        <NavDropdown.Item href="https://www.youtube.com/watch?v=bBC-nXj3Ng4" target="_blank" rel="noreferrer noopener">
                            How does the blockchain work (Youtube)
                        </NavDropdown.Item>
                        
                        <NavDropdown.Item href="https://scan.kcc.io/" target="_blank" rel="noreferrer noopener">
                            See the KCC Blockchain in action
                        </NavDropdown.Item>
                        
                        <NavDropdown.Divider />
                        
                        <NavDropdown.Item href="https://docs.permastore.app/" target="_blank" rel="noreferrer noopener">
                            API documentation
                        </NavDropdown.Item>
                    </NavDropdown>
                </Nav>
            
                {/*
                <Form inline className="form-inline my-2 my-lg-0">
                  <FormControl type="text" placeholder="Search" className="mr-sm-2" />
                  <Button variant="outline-success">Search</Button>
                </Form>
                */}
            
            </Navbar.Collapse>
        </Navbar>
    );
};

export default Header;