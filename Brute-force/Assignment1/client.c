


/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include<sys/wait.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>
#include <time.h>
#include<stdlib.h>
#define _GNU_SOURCE         /* See feature_test_macros(7) */
#include <unistd.h>
#include <sys/syscall.h>

int receive_image(int socket)
{ // Start function 
printf("hello1\n");
int buffersize = 0, recv_size = 0,size = 0, read_size, write_size, packet_index =1,stat;

char imagearray[10241],verify = '1';
FILE *image;
//find name of image
char fileName[1024];
read(socket,fileName,1024);
printf("file name ----->%s\n",fileName);
//Find the size of the image
do{
stat = read(socket, &size, sizeof(int));
}while(stat<0);

printf("Packet received.\n");
printf("Packet size: %i\n",stat);
printf("Image size: %i\n",size);
printf(" \n");

char buffer[] = "Got it";

printf("Reply sent\n");
printf(" \n");

image = fopen(fileName, "w");

if( image == NULL) {
printf("Error has occurred. Image file could not be opened\n");
return -1; }

//Loop while we have not received the entire file yet


int need_exit = 0;
struct timeval timeout = {10,0};

fd_set fds;
int buffer_fd, buffer_out;

while(recv_size < size) {
//while(packet_index < 2){

    FD_ZERO(&fds);
    FD_SET(socket,&fds);

    buffer_fd = select(FD_SETSIZE,&fds,NULL,NULL,&timeout);

    if (buffer_fd < 0)
       printf("error: bad file descriptor set.\n");

    if (buffer_fd == 0)
       printf("error: buffer read timeout expired.\n");

    if (buffer_fd > 0)
    {
        do{
               read_size = read(socket,imagearray, 10241);
            }while(read_size <0);

            printf("Packet number received: %i\n",packet_index);
        printf("Packet size: %i\n",read_size);


        //Write the currently read data into our image file
         write_size = fwrite(imagearray,1,read_size, image);
         printf("Written image size: %i\n",write_size); 

             if(read_size !=write_size) {
                 printf("error in read write\n");    }


             //Increment the total number of bytes read
             recv_size += read_size;
             packet_index++;
             printf("Total received image size: %i\n",recv_size);
             printf(" \n");
             printf(" \n");
    }

}


  fclose(image);
  printf("Image successfully Received!\n");
  return 1;
  }


int main(){
  int clientSocket;
  char buffer[10000];
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
  // serverAddr.sin_addr.s_addr = inet_addr("172.17.0.2");
  serverAddr.sin_addr.s_addr = inet_addr("172.17.0.2");
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Connect the socket to the server using the address struct ----*/
  addr_size = sizeof serverAddr;
  connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);

  /*---- Read the message from the server into the buffer ----*/
  while(1){
  	char in[1024]; //in = input 
  	char check[5]="exit\n";
    char *fileName; 
  	gets(in);
    printf("received input = %s\n",in);

  	// if(strncmp(in,"wget",4)==0){
  	// 	// send(clientSocket,in,1024,0);
  	// 	// recv(clientSocket, buffer, 1024, 0);
  	// 	// while(1){
  	// 	// 	printf("%s\n",buffer);
  	// 	// 	recv(clientSocket, buffer, 1024, 0);
  	// 	// 	if(strncmp(buffer,"done",4)==0){
  	// 	// 		printf("\n");
  	// 	// 		break;
  	// 	// 		free(in);
  	// 	// 	}
  	// 	// }
  	// }
    // else{
    	send(clientSocket,in,1024,0);
    /*---- Print the received message ----*/
    // recv(clientSocket, buffer, 1024, 0);

      // if(strncmp(buffer,"return",6)==0){
      //     return 0;
      // }

      int count;
      recv(clientSocket,(void *) &count, sizeof(int),0);
      printf("%d\n",count);
      while(count>0){ 
        
        receive_image(clientSocket);
        send(clientSocket,"ok",1024,0);
        count--;
      }
       receive_image(clientSocket);
      system(" google-chrome $(pwd)/index.html");
    	printf("done ...\n");
      break;
    // }
 }
 return 0;
}



