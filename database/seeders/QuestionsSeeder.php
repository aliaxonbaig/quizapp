<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionsData = [
            [
                'question' => 'What is the primary goal of information security governance?',
                'explanation' => 'The primary goal of information security governance is to ensure that security efforts align with and support the organization\'s objectives and strategies.',
                'answers' => [
                    'To block all cyberattacks' => 0,
                    'To create complex passwords' => 0,
                    'To ensure security efforts align with organizational objectives' => 1,
                    'To install antivirus software' => 0,
                ],
            ],
            [
                'question' => 'What is the difference between a risk and a threat in the context of information security?',
                'explanation' => 'A threat is a potential event or action that can harm an asset, while risk is the likelihood and impact of a threat materializing and causing harm.',
                'answers' => [
                    'There is no difference; they are the same thing' => 0,
                    'A risk is a potential event, and a threat is an event that has already occurred' => 0,
                    'A threat is the likelihood of a harmful event occurring, and risk is the potential harm from an event' => 1,
                    'A risk is a harmful event, and a threat is a potential event' => 0,
                ],
            ],
            [
                'question' => 'What is the purpose of a Security Policy?',
                'explanation' => 'A Security Policy defines the organization\'s security objectives, requirements, and responsibilities. It provides a framework for managing security and ensuring compliance with security standards.',
                'answers' => [
                    'To enforce strict security controls' => 0,
                    'To create backup copies of data' => 0,
                    'To define security objectives, requirements, and responsibilities' => 1,
                    'To install firewall software' => 0,
                ],
            ],
            [
                'question' => 'What is the concept of "need to know" in the context of access control?',
                'explanation' => 'The concept of "need to know" means that individuals should only have access to information and resources necessary to perform their job functions. It restricts access to what is required for a person to carry out their tasks effectively.',
                'answers' => [
                    'Everyone should have access to all information' => 0,
                    'Access should be granted based on job titles' => 0,
                    'Individuals should have access only to information necessary for their job functions' => 1,
                    'Access should be granted based on seniority' => 0,
                ],
            ],
            [
                'question' => 'What is the purpose of a Security Information and Event Management (SIEM) system?',
                'explanation' => 'A SIEM system collects, correlates, and analyzes security event data from various sources to provide real-time monitoring and alerting. Its primary purpose is to detect and respond to security incidents.',
                'answers' => [
                    'To play video games' => 0,
                    'To create graphical user interfaces' => 0,
                    'To store data for future reference' => 0,
                    'To detect and respond to security incidents' => 1,
                ],
            ],
            [
                'question' => 'What is the primary goal of security awareness training?',
                'explanation' => 'The primary goal of security awareness training is to educate employees and users about security risks and best practices. It aims to enhance security awareness and reduce the likelihood of security incidents caused by human errors.',
                'answers' => [
                    'To block all network traffic' => 0,
                    'To encrypt all network traffic' => 0,
                    'To slow down network traffic' => 0,
                    'To educate users about security risks and best practices' => 1,
                ],
            ],
            [
                'question' => 'What is the term for a security incident response plan that outlines the steps an organization should take in the event of a security breach?',
                'explanation' => 'An Incident Response Plan (IRP) is a structured approach for addressing and managing the aftermath of a security breach or cyberattack. It outlines the steps, responsibilities, and procedures to follow when responding to security incidents.',
                'answers' => [
                    'Security Awareness Plan' => 0,
                    'Disaster Recovery Plan' => 0,
                    'Business Continuity Plan' => 0,
                    'Incident Response Plan' => 1,
                ],
            ],
            [
                'question' => 'What is the primary purpose of a Business Impact Analysis (BIA) in the context of business continuity planning?',
                'explanation' => 'A Business Impact Analysis (BIA) assesses the potential impact of disruptions on an organization\'s critical business functions and processes. Its primary purpose is to identify and prioritize critical systems and resources for recovery.',
                'answers' => [
                    'To create a disaster recovery plan' => 0,
                    'To perform penetration testing' => 0,
                    'To assess the impact of security incidents' => 0,
                    'To identify critical business functions and prioritize recovery efforts' => 1,
                ],
            ],
            [
                'question' => 'What is the primary goal of a Security Risk Assessment?',
                'explanation' => 'The primary goal of a Security Risk Assessment is to identify, assess, and prioritize security risks and vulnerabilities within an organization. It helps in making informed decisions to mitigate and manage these risks effectively.',
                'answers' => [
                    'To install security software' => 0,
                    'To perform system backups' => 0,
                    'To create complex passwords' => 0,
                    'To identify, assess, and prioritize security risks and vulnerabilities' => 1,
                ],
            ],
            [
                'question' => 'What is the primary purpose of security controls in information security?',
                'explanation' => 'Security controls are implemented to reduce the risk of security incidents and protect assets. They include preventive, detective, and corrective measures that help mitigate threats and vulnerabilities.',
                'answers' => [
                    'To block all network traffic' => 0,
                    'To create backups of data' => 0,
                    'To slow down network traffic' => 0,
                    'To reduce the risk of security incidents and protect assets' => 1,
                ],
            ],
            [
                'question' => 'What is the primary goal of a Privacy Impact Assessment (PIA) in the context of privacy compliance?',
                'explanation' => 'A Privacy Impact Assessment (PIA) is conducted to assess the potential privacy risks and impacts of a project, system, or process. Its primary goal is to ensure that privacy considerations are integrated into decision-making and mitigate privacy risks.',
                'answers' => [
                    'To block all cyberattacks' => 0,
                    'To create complex passwords' => 0,
                    'To assess the impact of security incidents' => 0,
                    'To assess potential privacy risks and impacts and integrate privacy into decision-making' => 1,
                ],
            ],
            [
                'question' => 'What is the primary goal of a security incident response team?',
                'explanation' => 'The primary goal of a security incident response team is to detect, investigate, and respond to security incidents. It aims to minimize the impact of incidents, recover affected systems, and prevent future occurrences.',
                'answers' => [
                    'To create backups of data' => 0,
                    'To perform penetration testing' => 0,
                    'To block all network traffic' => 0,
                    'To detect, investigate, and respond to security incidents' => 1,
                ],
            ],
            [
                'question' => 'What is the primary purpose of a security baseline in configuration management?',
                'explanation' => 'A security baseline defines a set of security settings and configurations that are considered secure and recommended for a particular system or environment. Its primary purpose is to ensure that systems are configured securely and consistently.',
                'answers' => [
                    'To slow down network traffic' => 0,
                    'To install antivirus software' => 0,
                    'To create backups of data' => 0,
                    'To ensure systems are configured securely and consistently' => 1,
                ],
            ],
            [
                'question' => 'What is the term for a security incident that aims to disrupt or overload a system or network to the point of rendering it unavailable?',
                'explanation' => 'A Denial of Service (DoS) attack is a security incident that aims to disrupt or overload a system or network, making it unavailable to users. It typically involves overwhelming the target with a flood of traffic or requests.',
                'answers' => [
                    'Phishing attack' => 0,
                    'Brute force attack' => 0,
                    'SQL injection attack' => 0,
                    'Denial of Service (DoS) attack' => 1,
                ],
            ],
            [
                'question' => 'What is the primary goal of a risk assessment in information security?',
                'explanation' => 'The primary goal of a risk assessment is to identify and evaluate potential security risks and vulnerabilities within an organization. It provides the basis for making informed decisions about risk mitigation strategies.',
                'answers' => [
                    'To create a disaster recovery plan' => 0,
                    'To perform penetration testing' => 0,
                    'To install security software' => 0,
                    'To identify and evaluate potential security risks and vulnerabilities' => 1,
                ],
            ],
            [
                'question' => 'What is the term for the practice of impersonating a trusted entity to deceive individuals or gain unauthorized access to systems or data?',
                'explanation' => 'Phishing is the practice of impersonating a trusted entity, often through deceptive emails or websites, with the intention of deceiving individuals and gaining unauthorized access to systems or data.',
                'answers' => [
                    'Spoofing' => 0,
                    'Sniffing' => 0,
                    'Phishing' => 1,
                    'Hacking' => 0,
                ],
            ],
            [
                'question' => 'What is the primary goal of a Security Information and Event Management (SIEM) system?',
                'explanation' => 'A SIEM system collects, correlates, and analyzes security event data from various sources to provide real-time monitoring and alerting. Its primary purpose is to detect and respond to security incidents.',
                'answers' => [
                    'To play video games' => 0,
                    'To create graphical user interfaces' => 0,
                    'To store data for future reference' => 0,
                    'To detect and respond to security incidents' => 1,
                ],
            ],
            [
                'question' => 'What is the primary purpose of security awareness training?',
                'explanation' => 'The primary goal of security awareness training is to educate employees and users about security risks and best practices. It aims to enhance security awareness and reduce the likelihood of security incidents caused by human errors.',
                'answers' => [
                    'To block all network traffic' => 0,
                    'To encrypt all network traffic' => 0,
                    'To slow down network traffic' => 0,
                    'To educate users about security risks and best practices' => 1,
                ],
            ],
        ];

        foreach ($questionsData as $questionData) {
            $question = DB::table('questions')->insertGetId([
                'question' => $questionData['question'],
                'explanation' => $questionData['explanation'],
                'user_id' => 1, // Change this to the user ID you want to associate with the questions
                'domain_id' => 1, // Change this to the appropriate domain ID
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($questionData['answers'] as $answerText => $isCorrect) {
                DB::table('answers')->insert([
                    'answer' => $answerText,
                    'is_checked' => $isCorrect,
                    'question_id' => $question,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
