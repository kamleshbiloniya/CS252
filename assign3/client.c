
/* credit @Daniel Scocco */

/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include<sys/wait.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>
#include <time.h>
#include<stdlib.h>

int main(){
  int clientSocket;
  char buffer[1024];
  struct sockaddr_in serverAddr;
  socklen_t addr_size;

  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  clientSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
  serverAddr.sin_addr.s_addr = inet_addr("127.0.0.1");
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Connect the socket to the server using the address struct ----*/
  addr_size = sizeof serverAddr;
  connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);

  /*---- Read the message from the server into the buffer ----*/
  while(1){
  	char in[1024]; //in = input 
  	char check[5]="exit\n";
  	gets(in);
  	if(strncmp(in,"wget",4)==0){
  		send(clientSocket,in,1024,0);
  		recv(clientSocket, buffer, 1024, 0);
  		while(1){
  			printf("%s\n",buffer);
  			recv(clientSocket, buffer, 1024, 0);
  			if(strncmp(buffer,"done",4)==0){
  				printf("\n");
  				break;
  				free(in);
  			}
  		}
  	}
  	else{
  		send(clientSocket,in,1024,0);
	  /*---- Print the received message ----*/
		recv(clientSocket, buffer, 1024, 0);
		if(strncmp(buffer,"google",6)==0){
			system(buffer);
		}
		printf("Data received from server: %s\n",buffer);
  	}

 	
  }


  return 0;
}
