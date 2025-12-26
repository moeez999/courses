<script>
                      document.addEventListener("DOMContentLoaded", function() {
                          // Tab switching functionality
                          const tabButtons = document.querySelectorAll(".tab-btn");
                          const tabContents = document.querySelectorAll(".tab-content");
                          
                          // Show the first tab by default
                          tabButtons[0].classList.add("active");
                          tabContents[0].style.display = "block";
                          
                          tabButtons.forEach(button => {
                              button.addEventListener("click", function() {
                                  // Remove active class from all buttons
                                  tabButtons.forEach(btn => btn.classList.remove("active"));
                                  // Hide all tab contents
                                  tabContents.forEach(content => content.style.display = "none");
                                  
                                  // Add active class to clicked button
                                  this.classList.add("active");
                                  // Show the corresponding tab content
                                  const tabId = this.getAttribute("data-tab");
                                  document.getElementById(`${tabId}-tab`).style.display = "block";
                              });
                          });
                          
                          // Accordion functionality
                          const accordionItems = document.querySelectorAll(".accordion-item");
                          accordionItems.forEach(item => {
                              const header = item.querySelector(".accordion-header");
                              header.addEventListener("click", function() {
                                  // Toggle active class on the accordion item
                                  item.classList.toggle("active");
                                  
                                  // Toggle the accordion content
                                  const content = item.querySelector(".accordion-content");
                                  if (item.classList.contains("active")) {
                                      content.style.maxHeight = content.scrollHeight + "px";
                                  } else {
                                      content.style.maxHeight = "0";
                                  }
                              });
                              
                              // Initialize accordion content height
                              const content = item.querySelector(".accordion-content");
                              if (item.classList.contains("active")) {
                                  content.style.maxHeight = content.scrollHeight + "px";
                              } else {
                                  content.style.maxHeight = "0";
                              }
                          });
                      });
                      </script>

 <script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all profile sections (they're typically in divs with class 'profilefield')
    const sections =   document.querySelectorAll('.profile_tree .node_category');
     
    const tabSections = [sections[2], sections[3], sections[4]];
    const tabTitles = ['Miscellaneous', 'Reports', 'Administration'];
    
    // Create tab container in left column
    const tabWrapper = document.createElement('div');
    tabWrapper.className = 'modern-tab-wrapper';
    
    const tabNav = document.createElement('div');
    tabNav.className = 'modern-tab-nav';
    
    const tabContent = document.createElement('div');
    tabContent.className = 'modern-tab-content';
    
    leftColumn.appendChild(tabWrapper);
    tabWrapper.appendChild(tabNav);
    tabWrapper.appendChild(tabContent);
    
    // Process tab sections
    tabSections.forEach((section, index) => {
        if (!section) return;
        
        // Remove card title
        const cardTitle = section.querySelector('.card-body h5');
        if (cardTitle) cardTitle.remove();
        
        // Create tab button
        const tabButton = document.createElement('button');
        tabButton.className = 'modern-tab-btn';
        tabButton.textContent = tabTitles[index];
        tabButton.setAttribute('data-tab', index);
        if (index === 1) tabButton.classList.add('active');
        
        tabNav.appendChild(tabButton);
        
        // Create tab panel
        const tabPanel = document.createElement('div');
        tabPanel.className = 'modern-tab-panel';
        tabPanel.id = `tab-${index}`;
        if (index === 1) tabPanel.classList.add('active');
        
        // Move content
        while (section.firstChild) {
            tabPanel.appendChild(section.firstChild);
        }
        section.remove();
        tabContent.appendChild(tabPanel);
        
        // Click handler
        tabButton.addEventListener('click', function() {
            document.querySelectorAll('.modern-tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.modern-tab-panel').forEach(panel => panel.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(`tab-${this.getAttribute('data-tab')}`).classList.add('active');
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll(".modern-tab-btn");
    const tabPanels = document.querySelectorAll(".modern-tab-panel");
    
    tabButtons.forEach(button => {
        button.addEventListener("click", function() {
            // Remove active class from all buttons and panels
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabPanels.forEach(panel => panel.classList.remove("active"));
            
            // Add active class to clicked button and corresponding panel
            this.classList.add("active");
            const tabId = this.getAttribute("data-tab");
            document.getElementById("tab-" + tabId).classList.add("active");
        });
    });
});
</script>    

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality for both cards
    document.querySelectorAll('.tabs .tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Get parent card
            const card = this.closest('.card');
            
            // Remove active class from all buttons in this card
            card.querySelectorAll('.tab-btn').forEach(tb => tb.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Hide all tab contents in this card
            card.querySelectorAll('.feedback-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Show the selected tab content
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });
});
</script>                 