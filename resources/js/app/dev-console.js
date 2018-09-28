let styles = {
	logo: `
		background: transparent; 
		color: #0393B0
	`,
	title: `
      font-weight: bold;
      border-bottom: 1px solid black;
    `,
	info: `
	  font-weight: bold;
	`
}

let contents = {
	header: `Welcome to 
 ________   ___        ________   ___  ___   ________   _________   _______    ________   _____ ______      
|\\   ____\\ |\\  \\      |\\   __  \\ |\\  \\|\\  \\ |\\   ___ \\ |\\___   ___\\|\\  ___ \\  |\\   __  \\ |\\   _ \\  _   \\    
\\ \\  \\___| \\ \\  \\     \\ \\  \\|\\  \\\\ \\  \\\\\\  \\\\ \\  \\_|\\ \\\\|___ \\  \\_|\\ \\   __/| \\ \\  \\|\\  \\\\ \\  \\\\\\__\\ \\  \\   
 \\ \\  \\     \\ \\  \\     \\ \\  \\\\\\  \\\\ \\  \\\\\\  \\\\ \\  \\ \\\\ \\    \\ \\  \\  \\ \\  \\_|/__\\ \\   __  \\\\ \\  \\\\|__| \\  \\  
  \\ \\  \\____ \\ \\  \\____ \\ \\  \\\\\\  \\\\ \\  \\\\\\  \\\\ \\  \\_\\\\ \\    \\ \\  \\  \\ \\  \\_|\\ \\\\ \\  \\ \\  \\\\ \\  \\    \\ \\  \\ 
   \\ \\_______\\\\ \\_______\\\\ \\_______\\\\ \\_______\\\\ \\_______\\    \\ \\__\\  \\ \\_______\\\\ \\__\\ \\__\\\\ \\__\\    \\ \\__\\
    \\|_______| \\|_______| \\|_______| \\|_______| \\|_______|     \\|__|   \\|_______| \\|__|\\|__| \\|__|     \\|__|                                                                                                    
                                                                                                           
`,
	title1: 'MISSION',
	content1: `Nowadays, business development associates with the application of the achievements of IT to improve, enhance business performance. A challenging problem in the investment is the humanfactors. To run a good IT system for business, enterprises need an IT staff having sufficient knowledge.`,
	title2: 'RETAINER',
	content2: `Employers across all industry sectors to ensure that their internal sed Human Resource systems processes align to their business requirements idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth.`,
	title3: 'STRATEGY',
	content3: `Our strategy is to become an IT company providing professional services with various products and high technology.Consult, design information technology projects. Implement, monitor of information technology projects.`,

	address: '52 Nguyen Truong To Street, Ward 12, District 4, Ho Chi Minh City',
	phone: '+84 287 108 6688',
	email: 'info@cloudteam.vn',
	website: 'http://www.cloudteam.vn'
}

console.log(`%c${contents.header}`, styles.logo);
console.log(`%c
	Address: ${contents.address},
	Phone: ${contents.phone},
	Email: ${contents.email},
	Website: ${contents.website},
`, styles.info);

console.log(`%c${contents.title1}`, styles.title);
console.log(contents.content1);
console.log(`%c${contents.title2}`, styles.title);
console.log(contents.content2);
console.log(`%c${contents.title3}`, styles.title);
console.log(contents.content3);